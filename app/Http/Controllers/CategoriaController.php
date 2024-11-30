<?php

namespace App\Http\Controllers;

use App\Services\CategoriaService;
use App\Enums\TipoCategoria;
use App\Enums\StatusGeral;
use App\Traits\LogActivityTrait;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    use LogActivityTrait;

    protected $categoriaService;

    public function __construct(CategoriaService $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }

    public function index(Request $request)
    {
        $filtros = $request->only(['nome', 'tipo', 'status', 'apenas_raiz']);
        $categorias = $this->categoriaService->listar($filtros);

        $tipos = TipoCategoria::getDescriptions();
        
        return view('categorias.index', compact('categorias', 'tipos'));
    }

    public function create()
    {
        $tipos = TipoCategoria::getDescriptions();
        $categorias = $this->categoriaService->obterArvoreCompleta();
        
        return view('categorias.create', compact('tipos', 'categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'tipo' => ['required', Rule::in(TipoCategoria::getValues())],
            'categoria_pai_id' => 'nullable|exists:categorias,id',
            'status' => ['required', Rule::in(StatusGeral::getValues())]
        ]);

        try {
            $categoria = $this->categoriaService->criar($validated);
            $this->logCriacao('categoria', $categoria->id);

            return redirect()->route('categorias.index')
                ->with('success', 'Categoria criada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao criar categoria: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $categoria = $this->categoriaService->buscar($id);
        $tipos = TipoCategoria::getDescriptions();
        $categorias = $this->categoriaService->obterArvoreCompleta();
        
        return view('categorias.edit', compact('categoria', 'tipos', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'tipo' => ['required', Rule::in(TipoCategoria::getValues())],
            'categoria_pai_id' => 'nullable|exists:categorias,id',
            'status' => ['required', Rule::in(StatusGeral::getValues())]
        ]);

        try {
            $categoria = $this->categoriaService->atualizar($id, $validated);
            $this->logAtualizacao('categoria', $categoria->id);

            return redirect()->route('categorias.index')
                ->with('success', 'Categoria atualizada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao atualizar categoria: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoriaService->excluir($id);
            $this->logExclusao('categoria', $id);

            return redirect()->route('categorias.index')
                ->with('success', 'Categoria excluída com sucesso!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erro ao excluir categoria: ' . $e->getMessage());
        }
    }

    public function mover(Request $request, $id)
    {
        $validated = $request->validate([
            'categoria_pai_id' => 'nullable|exists:categorias,id'
        ]);

        try {
            $this->categoriaService->mover($id, $validated['categoria_pai_id']);
            $this->logAtualizacao('categoria', $id, 'Movida para nova categoria pai');

            return redirect()->route('categorias.index')
                ->with('success', 'Categoria movida com sucesso!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erro ao mover categoria: ' . $e->getMessage());
        }
    }
}
