<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository extends BaseRepository
{
    public function __construct(Produto $model)
    {
        parent::__construct($model);
    }

    public function listarComFiltros($filtros = [])
    {
        $query = $this->model->query();

        if (isset($filtros['nome'])) {
            $query->where('nome', 'like', '%' . $filtros['nome'] . '%');
        }

        if (isset($filtros['categoria_id'])) {
            $query->where('categoria_id', $filtros['categoria_id']);
        }

        if (isset($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        if (isset($filtros['preco_min'])) {
            $query->where('preco', '>=', $filtros['preco_min']);
        }

        if (isset($filtros['preco_max'])) {
            $query->where('preco', '<=', $filtros['preco_max']);
        }

        return $query->with('categoria')->orderBy('nome', 'asc')->paginate(10);
    }

    public function buscarPorSku($sku)
    {
        return $this->model->where('sku', $sku)->first();
    }

    public function atualizarEstoque($id, $quantidade, $operacao = 'adicionar')
    {
        $produto = $this->find($id);
        
        if ($operacao === 'adicionar') {
            $produto->estoque += $quantidade;
        } else {
            $produto->estoque -= $quantidade;
        }

        $produto->save();
        return $produto;
    }
}
