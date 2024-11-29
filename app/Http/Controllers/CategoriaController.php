<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index()
    {
        // Busca apenas categorias principais (nível 1)
        $categorias = Categoria::where('nivel', 1)
            ->with('subcategorias')
            ->orderBy('codigo')
            ->get();

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        $categoriasPai = Categoria::orderBy('codigo')->get();
        return view('categorias.create', compact('categoriasPai'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:categorias,codigo',
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'tipo' => 'required|in:receita,despesa',
            'categoria_pai_id' => 'nullable|exists:categorias,id'
        ]);

        // Define o nível baseado na categoria pai
        if ($request->categoria_pai_id) {
            $categoriaPai = Categoria::findOrFail($request->categoria_pai_id);
            $validated['nivel'] = $categoriaPai->nivel + 1;
        } else {
            $validated['nivel'] = 1;
        }

        Categoria::create($validated);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(Categoria $categoria)
    {
        $categoriasPai = Categoria::where('id', '!=', $categoria->id)
            ->whereNotIn('id', $categoria->todasSubcategorias->pluck('id'))
            ->orderBy('codigo')
            ->get();

        return view('categorias.edit', compact('categoria', 'categoriasPai'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'codigo' => ['required', Rule::unique('categorias')->ignore($categoria)],
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'tipo' => 'required|in:receita,despesa',
            'categoria_pai_id' => [
                'nullable',
                'exists:categorias,id',
                Rule::notIn([$categoria->id]),
                function ($attribute, $value, $fail) use ($categoria) {
                    if ($value && in_array($value, $categoria->todasSubcategorias->pluck('id')->toArray())) {
                        $fail('Não é possível selecionar uma subcategoria como categoria pai.');
                    }
                }
            ],
            'ativo' => 'boolean'
        ]);

        // Atualiza o nível baseado na categoria pai
        if ($request->categoria_pai_id) {
            $categoriaPai = Categoria::findOrFail($request->categoria_pai_id);
            $validated['nivel'] = $categoriaPai->nivel + 1;
        } else {
            $validated['nivel'] = 1;
        }

        // Atualiza os níveis das subcategorias
        if ($categoria->nivel != $validated['nivel']) {
            $this->atualizarNiveisSubcategorias($categoria, $validated['nivel']);
        }

        $categoria->update($validated);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->temSubcategorias()) {
            return back()->with('error', 'Não é possível excluir uma categoria que possui subcategorias.');
        }

        if ($categoria->contasPagar()->exists() || $categoria->contasReceber()->exists()) {
            return back()->with('error', 'Não é possível excluir uma categoria que possui movimentações financeiras.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }

    /**
     * Atualiza recursivamente os níveis das subcategorias
     */
    private function atualizarNiveisSubcategorias(Categoria $categoria, int $novoNivelPai)
    {
        foreach ($categoria->subcategorias as $subcategoria) {
            $novoNivel = $novoNivelPai + 1;
            $subcategoria->update(['nivel' => $novoNivel]);
            $this->atualizarNiveisSubcategorias($subcategoria, $novoNivel);
        }
    }

    /**
     * Retorna as subcategorias de uma categoria específica (para AJAX)
     */
    public function getSubcategorias(Categoria $categoria)
    {
        return response()->json([
            'subcategorias' => $categoria->subcategorias()->orderBy('codigo')->get()
        ]);
    }
}
