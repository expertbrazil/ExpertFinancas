<?php

namespace App\Repositories;

use App\Models\ContaPagar;

class ContaPagarRepository extends BaseRepository
{
    public function __construct(ContaPagar $model)
    {
        parent::__construct($model);
    }

    public function listarComFiltros($filtros = [])
    {
        $query = $this->model->query();

        if (isset($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        if (isset($filtros['data_inicio']) && isset($filtros['data_fim'])) {
            $query->whereBetween('data_vencimento', [$filtros['data_inicio'], $filtros['data_fim']]);
        }

        if (isset($filtros['fornecedor'])) {
            $query->where('fornecedor', 'like', '%' . $filtros['fornecedor'] . '%');
        }

        return $query->orderBy('data_vencimento', 'asc')->paginate(10);
    }
}
