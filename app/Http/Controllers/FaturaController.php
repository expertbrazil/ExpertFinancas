<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FaturaController extends Controller
{
    public function index(Request $request)
    {
        $query = Fatura::with(['cliente']);

        // Filtro por cliente
        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->cliente . '%');
            });
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por data
        if ($request->filled('data_inicio')) {
            $query->where('data_vencimento', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->where('data_vencimento', '<=', $request->data_fim);
        }

        // Ordenação padrão por data de vencimento
        $query->orderBy('data_vencimento', 'desc');

        $faturas = $query->paginate(10)->withQueryString();

        // Estatísticas para os cards de resumo
        $stats = [
            'total' => $query->count(),
            'valor_total' => $query->sum('valor'),
            'pendentes' => $query->where('status', 'pendente')->count(),
            'vencidas' => $query->whereDate('data_vencimento', '<', now())
                               ->where('status', 'pendente')
                               ->count()
        ];

        return view('faturas.index', compact('faturas', 'stats'));
    }

    public function create()
    {
        $clientes = Cliente::where('ativo', true)->get();
        return view('faturas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'numero' => 'required|string|unique:faturas,numero',
            'data_emissao' => 'required|date',
            'data_vencimento' => 'required|date|after_or_equal:data_emissao',
            'valor' => 'required|numeric|min:0',
            'status' => 'required|in:pendente,pago,cancelado',
            'descricao' => 'nullable|string',
            'itens' => 'required|array|min:1',
            'itens.*.descricao' => 'required|string',
            'itens.*.valor' => 'required|numeric|min:0',
            'itens.*.quantidade' => 'required|integer|min:1'
        ]);

        $fatura = new Fatura();
        $fatura->cliente_id = $request->cliente_id;
        $fatura->numero = $request->numero;
        $fatura->data_emissao = $request->data_emissao;
        $fatura->data_vencimento = $request->data_vencimento;
        $fatura->valor = $request->valor;
        $fatura->status = $request->status;
        $fatura->descricao = $request->descricao;
        $fatura->save();

        foreach ($request->itens as $item) {
            $fatura->itens()->create([
                'descricao' => $item['descricao'],
                'valor' => $item['valor'],
                'quantidade' => $item['quantidade']
            ]);
        }

        return redirect()->route('faturas.show', $fatura)
            ->with('success', 'Fatura criada com sucesso!');
    }

    public function show(Fatura $fatura)
    {
        $fatura->load(['cliente', 'itens']);
        return view('faturas.show', compact('fatura'));
    }

    public function edit(Fatura $fatura)
    {
        if ($fatura->status === 'pago') {
            return redirect()->route('faturas.show', $fatura)
                ->with('error', 'Não é possível editar uma fatura já paga.');
        }

        $clientes = Cliente::where('ativo', true)->get();
        return view('faturas.edit', compact('fatura', 'clientes'));
    }

    public function update(Request $request, Fatura $fatura)
    {
        if ($fatura->status === 'pago') {
            return redirect()->route('faturas.show', $fatura)
                ->with('error', 'Não é possível editar uma fatura já paga.');
        }

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'numero' => 'required|string|unique:faturas,numero,' . $fatura->id,
            'data_emissao' => 'required|date',
            'data_vencimento' => 'required|date|after_or_equal:data_emissao',
            'valor' => 'required|numeric|min:0',
            'status' => 'required|in:pendente,pago,cancelado',
            'descricao' => 'nullable|string',
            'itens' => 'required|array|min:1',
            'itens.*.descricao' => 'required|string',
            'itens.*.valor' => 'required|numeric|min:0',
            'itens.*.quantidade' => 'required|integer|min:1'
        ]);

        $fatura->update([
            'cliente_id' => $request->cliente_id,
            'numero' => $request->numero,
            'data_emissao' => $request->data_emissao,
            'data_vencimento' => $request->data_vencimento,
            'valor' => $request->valor,
            'status' => $request->status,
            'descricao' => $request->descricao
        ]);

        // Atualiza os itens
        $fatura->itens()->delete();
        foreach ($request->itens as $item) {
            $fatura->itens()->create([
                'descricao' => $item['descricao'],
                'valor' => $item['valor'],
                'quantidade' => $item['quantidade']
            ]);
        }

        return redirect()->route('faturas.show', $fatura)
            ->with('success', 'Fatura atualizada com sucesso!');
    }

    public function destroy(Fatura $fatura)
    {
        if ($fatura->status === 'pago') {
            return redirect()->route('faturas.show', $fatura)
                ->with('error', 'Não é possível excluir uma fatura já paga.');
        }

        $fatura->delete();

        return redirect()->route('faturas.index')
            ->with('success', 'Fatura excluída com sucesso!');
    }
}
