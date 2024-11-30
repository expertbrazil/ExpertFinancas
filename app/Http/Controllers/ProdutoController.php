<?php

namespace App\Http\Controllers;

use App\Services\ProdutoService;
use App\Services\CategoriaService;
use App\Enums\StatusGeral;
use App\Traits\LogActivityTrait;
use App\Traits\MoneyTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdutoController extends Controller
{
    use LogActivityTrait, MoneyTrait;

    protected $produtoService;
    protected $categoriaService;

    public function __construct(
        ProdutoService $produtoService,
        CategoriaService $categoriaService
    ) {
        $this->produtoService = $produtoService;
        $this->categoriaService = $categoriaService;
    }

    public function index(Request $request)
    {
        $filtros = $request->only([
            'nome', 'codigo', 'categoria_id', 
            'preco_min', 'preco_max', 
            'estoque_min', 'estoque_max',
            'status'
        ]);

        $produtos = $this->produtoService->listar($filtros);
        $categorias = $this->categoriaService->listarParaSelect();

        return view('produtos.index', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'status_list' => StatusGeral::getDescriptions(),
            'filtros' => $filtros
        ]);
    }

    public function create()
    {
        return view('produtos.create', [
            'categorias' => $this->categoriaService->listarParaSelect(),
            'status_list' => StatusGeral::getDescriptions()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'codigo' => 'required|unique:produtos,codigo',
            'categoria_id' => 'required|exists:categorias,id',
            'descricao' => 'nullable',
            'preco_custo' => ['required', 'regex:/^\d*\.?\d{2}$/'],
            'preco_venda' => ['required', 'regex:/^\d*\.?\d{2}$/'],
            'margem_lucro' => 'nullable|numeric|min:0|max:100',
            'estoque' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'status' => ['required', Rule::in(StatusGeral::getValues())],
            'imagem' => 'nullable|image|max:2048',
            'peso' => 'nullable|numeric|min:0',
            'dimensoes' => 'nullable|json',
            'codigo_barras' => 'nullable|unique:produtos,codigo_barras',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'unidade_medida' => 'nullable|string|max:10',
            'localizacao_estoque' => 'nullable|string|max:50'
        ]);

        try {
            // Formata valores monetários
            $validated['preco_custo'] = $this->convertMoneyToDecimal($validated['preco_custo']);
            $validated['preco_venda'] = $this->convertMoneyToDecimal($validated['preco_venda']);

            $produto = $this->produtoService->criar($validated);
            $this->logCriacao('produto', $produto->id);

            return redirect()->route('produtos.index')
                ->with('success', 'Produto cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao cadastrar produto: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $produto = $this->produtoService->buscar($id);
            return view('produtos.show', compact('produto'));
        } catch (\Exception $e) {
            return redirect()->route('produtos.index')
                ->with('error', 'Produto não encontrado.');
        }
    }

    public function edit($id)
    {
        try {
            $produto = $this->produtoService->buscar($id);
            return view('produtos.edit', [
                'produto' => $produto,
                'categorias' => $this->categoriaService->listarParaSelect(),
                'status_list' => StatusGeral::getDescriptions()
            ]);
        } catch (\Exception $e) {
            return redirect()->route('produtos.index')
                ->with('error', 'Produto não encontrado.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'codigo' => ['required', Rule::unique('produtos')->ignore($id)],
            'categoria_id' => 'required|exists:categorias,id',
            'descricao' => 'nullable',
            'preco_custo' => ['required', 'regex:/^\d*\.?\d{2}$/'],
            'preco_venda' => ['required', 'regex:/^\d*\.?\d{2}$/'],
            'margem_lucro' => 'nullable|numeric|min:0|max:100',
            'estoque' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'status' => ['required', Rule::in(StatusGeral::getValues())],
            'imagem' => 'nullable|image|max:2048',
            'peso' => 'nullable|numeric|min:0',
            'dimensoes' => 'nullable|json',
            'codigo_barras' => ['nullable', Rule::unique('produtos')->ignore($id)],
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'unidade_medida' => 'nullable|string|max:10',
            'localizacao_estoque' => 'nullable|string|max:50'
        ]);

        try {
            // Formata valores monetários
            $validated['preco_custo'] = $this->convertMoneyToDecimal($validated['preco_custo']);
            $validated['preco_venda'] = $this->convertMoneyToDecimal($validated['preco_venda']);

            $produto = $this->produtoService->atualizar($id, $validated);
            $this->logAtualizacao('produto', $produto->id);

            return redirect()->route('produtos.index')
                ->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao atualizar produto: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->produtoService->excluir($id);
            $this->logExclusao('produto', $id);

            return redirect()->route('produtos.index')
                ->with('success', 'Produto excluído com sucesso!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erro ao excluir produto: ' . $e->getMessage());
        }
    }

    public function atualizarEstoque(Request $request, $id)
    {
        $validated = $request->validate([
            'quantidade' => 'required|integer',
            'operacao' => 'required|in:adicionar,remover'
        ]);

        try {
            $this->produtoService->atualizarEstoque(
                $id,
                $validated['quantidade'],
                $validated['operacao']
            );

            $this->logAtualizacao('produto_estoque', $id, [
                'quantidade' => $validated['quantidade'],
                'operacao' => $validated['operacao']
            ]);

            return back()->with('success', 'Estoque atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar estoque: ' . $e->getMessage());
        }
    }
}
