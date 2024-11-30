<?php

namespace App\Services;

use App\Repositories\ClienteRepository;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;

class ClienteService
{
    use UploadTrait;

    protected $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function listar($filtros = [])
    {
        return $this->clienteRepository->listarComFiltros($filtros);
    }

    public function criar(array $dados)
    {
        DB::beginTransaction();
        try {
            // Verifica duplicidade de CPF/CNPJ
            if ($this->clienteRepository->buscarPorCpfCnpj($dados['cpf_cnpj'])) {
                throw new \Exception('CPF/CNPJ já cadastrado');
            }

            // Verifica duplicidade de email
            if (isset($dados['email']) && $this->clienteRepository->buscarPorEmail($dados['email'])) {
                throw new \Exception('Email já cadastrado');
            }

            // Upload de foto se existir
            if (isset($dados['foto']) && $dados['foto']) {
                $dados['foto'] = $this->uploadFile($dados['foto'], 'clientes');
            }

            $cliente = $this->clienteRepository->create($dados);
            
            DB::commit();
            return $cliente;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizar($id, array $dados)
    {
        DB::beginTransaction();
        try {
            $cliente = $this->clienteRepository->find($id);

            // Verifica duplicidade de CPF/CNPJ
            if (isset($dados['cpf_cnpj'])) {
                $existente = $this->clienteRepository->buscarPorCpfCnpj($dados['cpf_cnpj']);
                if ($existente && $existente->id !== $id) {
                    throw new \Exception('CPF/CNPJ já cadastrado');
                }
            }

            // Verifica duplicidade de email
            if (isset($dados['email'])) {
                $existente = $this->clienteRepository->buscarPorEmail($dados['email']);
                if ($existente && $existente->id !== $id) {
                    throw new \Exception('Email já cadastrado');
                }
            }

            // Upload de nova foto se existir
            if (isset($dados['foto']) && $dados['foto']) {
                if ($cliente->foto) {
                    $this->deleteFile($cliente->foto);
                }
                $dados['foto'] = $this->uploadFile($dados['foto'], 'clientes');
            }

            $cliente = $this->clienteRepository->update($id, $dados);
            
            DB::commit();
            return $cliente;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function excluir($id)
    {
        DB::beginTransaction();
        try {
            $cliente = $this->clienteRepository->find($id);
            
            // Remove foto se existir
            if ($cliente->foto) {
                $this->deleteFile($cliente->foto);
            }

            $this->clienteRepository->delete($id);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function buscar($id)
    {
        return $this->clienteRepository->find($id);
    }
}
