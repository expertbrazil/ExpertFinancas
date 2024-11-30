<?php

namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository extends BaseRepository
{
    public function __construct(Cliente $model)
    {
        parent::__construct($model);
    }

    public function listarComFiltros($filtros = [])
    {
        $query = $this->model->query();

        if (isset($filtros['nome'])) {
            $query->where('nome', 'like', '%' . $filtros['nome'] . '%');
        }

        if (isset($filtros['email'])) {
            $query->where('email', 'like', '%' . $filtros['email'] . '%');
        }

        if (isset($filtros['cpf_cnpj'])) {
            $query->where('cpf_cnpj', 'like', '%' . $filtros['cpf_cnpj'] . '%');
        }

        if (isset($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        return $query->orderBy('nome', 'asc')->paginate(10);
    }

    public function buscarPorCpfCnpj($cpfCnpj)
    {
        return $this->model->where('cpf_cnpj', $cpfCnpj)->first();
    }

    public function buscarPorEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
