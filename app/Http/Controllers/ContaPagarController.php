<?php

namespace App\Http\Controllers;

use App\Models\ContaPagar;
use App\Models\Cliente;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContaPagarController extends Controller
{
    public function index()
    {
        $contasPagar = ContaPagar::with(['fornecedor', 'categoria'])
            ->orderBy('data_vencimento')
            ->paginate(10);
            
        return view('contas-pagar.index', compact('contasPagar'));
    }

    public function create()
    {
        $fornecedores = Cliente::orderBy('nome_completo')->get();
        $categorias = Categoria::where('tipo', 'despesa')->orderBy('nome')->get();
        
        return view('contas-pagar.create', compact('fornecedores', 'categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'fornecedor_id' => 'nullable|exists:clientes,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'forma_pagamento' => 'nullable|max:255',
            'observacao' => 'nullable'
        ]);

        ContaPagar::create($validated);

        return redirect()->route('contas-pagar.index')
            ->with('success', 'Conta a pagar cadastrada com sucesso!');
    }

    public function show(ContaPagar $contaPagar)
    {
        $contaPagar->load(['fornecedor', 'categoria']);
        return view('contas-pagar.show', compact('contaPagar'));
    }

    public function edit(ContaPagar $contaPagar)
    {
        $fornecedores = Cliente::orderBy('nome_completo')->get();
        $categorias = Categoria::where('tipo', 'despesa')->orderBy('nome')->get();
        
        return view('contas-pagar.edit', compact('contaPagar', 'fornecedores', 'categorias'));
    }

    public function update(Request $request, ContaPagar $contaPagar)
    {
        $validated = $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'fornecedor_id' => 'nullable|exists:clientes,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'forma_pagamento' => 'nullable|max:255',
            'observacao' => 'nullable'
        ]);

        $contaPagar->update($validated);

        return redirect()->route('contas-pagar.index')
            ->with('success', 'Conta a pagar atualizada com sucesso!');
    }

    public function destroy(ContaPagar $contaPagar)
    {
        $contaPagar->delete();

        return redirect()->route('contas-pagar.index')
            ->with('success', 'Conta a pagar excluída com sucesso!');
    }

    public function updateStatus(Request $request, ContaPagar $conta)
    {
        $validated = $request->validate([
            'status' => 'required|in:pendente,pago,cancelado',
            'data_pagamento' => 'required_if:status,pago|nullable|date'
        ]);

        $conta->update([
            'status' => $validated['status'],
            'data_pagamento' => $validated['status'] === 'pago' ? $validated['data_pagamento'] : null
        ]);

        return redirect()->back()->with('success', 'Status da conta atualizado com sucesso!');
    }
}
