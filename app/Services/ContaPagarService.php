<?php

namespace App\Services;

use App\Repositories\ContaPagarRepository;
use App\Enums\StatusConta;
use Carbon\Carbon;

class ContaPagarService
{
    protected $contaPagarRepository;

    public function __construct(ContaPagarRepository $contaPagarRepository)
    {
        $this->contaPagarRepository = $contaPagarRepository;
    }

    public function listarContas($filtros = [])
    {
        return $this->contaPagarRepository->listarComFiltros($filtros);
    }

    public function criar(array $dados)
    {
        // Validação e formatação de dados
        $dados['status'] = $dados['status'] ?? StatusConta::PENDENTE->value;
        if (isset($dados['data_vencimento'])) {
            $dados['data_vencimento'] = Carbon::parse($dados['data_vencimento'])->format('Y-m-d');
        }

        return $this->contaPagarRepository->create($dados);
    }

    public function atualizar($id, array $dados)
    {
        if (isset($dados['data_vencimento'])) {
            $dados['data_vencimento'] = Carbon::parse($dados['data_vencimento'])->format('Y-m-d');
        }

        return $this->contaPagarRepository->update($id, $dados);
    }

    public function atualizarStatus($id, string $status)
    {
        if (!in_array($status, StatusConta::getValues())) {
            throw new \InvalidArgumentException('Status inválido');
        }

        $dados = ['status' => $status];
        if ($status === StatusConta::PAGO->value) {
            $dados['data_pagamento'] = now();
        }

        return $this->contaPagarRepository->update($id, $dados);
    }

    public function excluir($id)
    {
        return $this->contaPagarRepository->delete($id);
    }
}
