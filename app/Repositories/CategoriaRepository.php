<?php

namespace App\Repositories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;

class CategoriaRepository extends BaseRepository
{
    public function __construct(Categoria $model)
    {
        parent::__construct($model);
    }

    public function listarComFiltros($filtros = [])
    {
        $query = $this->model->query();

        if (isset($filtros['nome'])) {
            $query->where('nome', 'like', '%' . $filtros['nome'] . '%');
        }

        if (isset($filtros['tipo'])) {
            $query->where('tipo', $filtros['tipo']);
        }

        if (isset($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        // Filtra apenas categorias raiz (sem pai) se especificado
        if (isset($filtros['apenas_raiz']) && $filtros['apenas_raiz']) {
            $query->whereNull('categoria_pai_id');
        }

        // Inclui toda a árvore de subcategorias se especificado
        if (isset($filtros['incluir_arvore']) && $filtros['incluir_arvore']) {
            $query->with('subcategorias');
        }

        return $query->orderBy('nome', 'asc')->paginate(10);
    }

    public function obterArvoreCompleta($tipo = null)
    {
        $query = $this->model->whereNull('categoria_pai_id')
            ->with(['subcategorias' => function ($query) {
                $query->orderBy('nome', 'asc');
            }]);

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        return $query->orderBy('nome', 'asc')->get();
    }

    public function obterCaminhoAteRaiz($categoriaId): Collection
    {
        $caminho = new Collection();
        $categoria = $this->find($categoriaId);

        while ($categoria) {
            $caminho->prepend($categoria);
            $categoria = $categoria->categoriaPai;
        }

        return $caminho;
    }

    public function obterTodasSubcategorias($categoriaId): Collection
    {
        $subcategorias = new Collection();
        $this->coletarSubcategorias($categoriaId, $subcategorias);
        return $subcategorias;
    }

    protected function coletarSubcategorias($categoriaId, Collection &$subcategorias)
    {
        $categoria = $this->find($categoriaId);
        $filhas = $categoria->subcategorias;

        foreach ($filhas as $filha) {
            $subcategorias->push($filha);
            $this->coletarSubcategorias($filha->id, $subcategorias);
        }
    }

    public function verificarCiclo($categoriaId, $novoPaiId): bool
    {
        if ($categoriaId == $novoPaiId) {
            return true;
        }

        $caminhoNovoPai = $this->obterCaminhoAteRaiz($novoPaiId);
        return $caminhoNovoPai->contains('id', $categoriaId);
    }

    public function mover($categoriaId, $novoPaiId = null)
    {
        if ($novoPaiId && $this->verificarCiclo($categoriaId, $novoPaiId)) {
            throw new \Exception('Não é possível mover uma categoria para uma de suas subcategorias');
        }

        return $this->update($categoriaId, ['categoria_pai_id' => $novoPaiId]);
    }
}
