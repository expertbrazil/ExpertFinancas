<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->paginate(10);
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'codigo' => 'required|unique:produtos,codigo',
            'descricao' => 'nullable',
            'preco_custo' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
        ]);

        Produto::create($validated);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'codigo' => 'required|unique:produtos,codigo,' . $produto->id,
            'descricao' => 'nullable',
            'preco_custo' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'ativo' => 'boolean'
        ]);

        $produto->update($validated);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}
