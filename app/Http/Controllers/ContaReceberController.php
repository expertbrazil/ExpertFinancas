<?php

namespace App\Http\Controllers;

use App\Models\ContaReceber;
use App\Models\Cliente;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContaReceberController extends Controller
{
    public function index()
    {
        $contasReceber = ContaReceber::with(['cliente', 'categoria'])
            ->orderBy('data_vencimento')
            ->paginate(10);
            
        return view('contas-receber.index', compact('contasReceber'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome_completo')->get();
        $categorias = Categoria::where('tipo', 'receita')->orderBy('nome')->get();
        
        return view('contas-receber.create', compact('clientes', 'categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'cliente_id' => 'nullable|exists:clientes,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'forma_recebimento' => 'nullable|max:255',
            'observacao' => 'nullable'
        ]);

        ContaReceber::create($validated);

        return redirect()->route('contas-receber.index')
            ->with('success', 'Conta a receber cadastrada com sucesso!');
    }

    public function show(ContaReceber $contaReceber)
    {
        $contaReceber->load(['cliente', 'categoria']);
        return view('contas-receber.show', compact('contaReceber'));
    }

    public function edit(ContaReceber $contaReceber)
    {
        $clientes = Cliente::orderBy('nome_completo')->get();
        $categorias = Categoria::where('tipo', 'receita')->orderBy('nome')->get();
        
        return view('contas-receber.edit', compact('contaReceber', 'clientes', 'categorias'));
    }

    public function update(Request $request, ContaReceber $contaReceber)
    {
        $validated = $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'cliente_id' => 'nullable|exists:clientes,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'forma_recebimento' => 'nullable|max:255',
            'observacao' => 'nullable'
        ]);

        $contaReceber->update($validated);

        return redirect()->route('contas-receber.index')
            ->with('success', 'Conta a receber atualizada com sucesso!');
    }

    public function destroy(ContaReceber $contaReceber)
    {
        $contaReceber->delete();

        return redirect()->route('contas-receber.index')
            ->with('success', 'Conta a receber excluída com sucesso!');
    }

    public function updateStatus(Request $request, ContaReceber $conta)
    {
        $validated = $request->validate([
            'status' => 'required|in:pendente,pago,cancelado',
            'data_recebimento' => 'required_if:status,pago|nullable|date'
        ]);

        $conta->update([
            'status' => $validated['status'],
            'data_recebimento' => $validated['status'] === 'pago' ? $validated['data_recebimento'] : null
        ]);

        return redirect()->back()->with('success', 'Status da conta atualizado com sucesso!');
    }
}
