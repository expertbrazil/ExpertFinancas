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
            $query->where(function($q) use ($filtros) {
                $q->where('nome_completo', 'like', '%' . $filtros['nome'] . '%')
                  ->orWhere('razao_social', 'like', '%' . $filtros['nome'] . '%');
            });
        }

        if (isset($filtros['email'])) {
            $query->where('email', 'like', '%' . $filtros['email'] . '%');
        }

        if (isset($filtros['cpf_cnpj'])) {
            $query->where(function($q) use ($filtros) {
                $q->where('cpf', 'like', '%' . $filtros['cpf_cnpj'] . '%')
                  ->orWhere('cnpj', 'like', '%' . $filtros['cpf_cnpj'] . '%');
            });
        }

        if (isset($filtros['tipo_pessoa'])) {
            $query->where('tipo_pessoa', $filtros['tipo_pessoa']);
        }

        if (isset($filtros['status'])) {
            $query->where('ativo', $filtros['status']);
        }

        return $query->orderByRaw('COALESCE(nome_completo, razao_social) ASC')->paginate(10);
    }

    public function buscarPorCpfCnpj($cpfCnpj)
    {
        return $this->model->where('cpf', $cpfCnpj)
                          ->orWhere('cnpj', $cpfCnpj)
                          ->first();
    }

    public function buscarPorEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
