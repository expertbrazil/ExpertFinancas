<?php

namespace App\Services;

use App\Repositories\CategoriaRepository;
use App\Enums\TipoCategoria;
use Illuminate\Support\Facades\DB;

class CategoriaService
{
    protected $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function listar($filtros = [])
    {
        return $this->categoriaRepository->listarComFiltros($filtros);
    }

    public function obterArvoreCompleta($tipo = null)
    {
        return $this->categoriaRepository->obterArvoreCompleta($tipo);
    }

    public function criar(array $dados)
    {
        DB::beginTransaction();
        try {
            // Valida o tipo da categoria
            if (!in_array($dados['tipo'], TipoCategoria::getValues())) {
                throw new \Exception('Tipo de categoria inválido');
            }

            // Se tem categoria pai, verifica se existe e se é do mesmo tipo
            if (!empty($dados['categoria_pai_id'])) {
                $categoriaPai = $this->categoriaRepository->find($dados['categoria_pai_id']);
                if ($categoriaPai->tipo !== $dados['tipo']) {
                    throw new \Exception('A categoria pai deve ser do mesmo tipo');
                }
            }

            $categoria = $this->categoriaRepository->create($dados);
            
            DB::commit();
            return $categoria;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizar($id, array $dados)
    {
        DB::beginTransaction();
        try {
            $categoria = $this->categoriaRepository->find($id);

            // Não permite alterar o tipo se já tiver subcategorias
            if (isset($dados['tipo']) && $dados['tipo'] !== $categoria->tipo) {
                $subcategorias = $this->categoriaRepository->obterTodasSubcategorias($id);
                if ($subcategorias->isNotEmpty()) {
                    throw new \Exception('Não é possível alterar o tipo de uma categoria que possui subcategorias');
                }
            }

            // Se está alterando a categoria pai, valida o novo pai
            if (isset($dados['categoria_pai_id']) && $dados['categoria_pai_id'] !== $categoria->categoria_pai_id) {
                if ($dados['categoria_pai_id']) {
                    $novoPai = $this->categoriaRepository->find($dados['categoria_pai_id']);
                    if ($novoPai->tipo !== $categoria->tipo) {
                        throw new \Exception('A nova categoria pai deve ser do mesmo tipo');
                    }
                }
                
                // Verifica se não está criando um ciclo
                if ($this->categoriaRepository->verificarCiclo($id, $dados['categoria_pai_id'])) {
                    throw new \Exception('Não é possível mover uma categoria para uma de suas subcategorias');
                }
            }

            $categoria = $this->categoriaRepository->update($id, $dados);
            
            DB::commit();
            return $categoria;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function mover($id, $novoPaiId = null)
    {
        DB::beginTransaction();
        try {
            $resultado = $this->categoriaRepository->mover($id, $novoPaiId);
            DB::commit();
            return $resultado;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function excluir($id)
    {
        DB::beginTransaction();
        try {
            // Verifica se tem subcategorias
            $subcategorias = $this->categoriaRepository->obterTodasSubcategorias($id);
            if ($subcategorias->isNotEmpty()) {
                throw new \Exception('Não é possível excluir uma categoria que possui subcategorias');
            }

            // Verifica se tem produtos/serviços associados
            $categoria = $this->categoriaRepository->find($id);
            if ($categoria->produtos()->exists() || $categoria->servicos()->exists()) {
                throw new \Exception('Não é possível excluir uma categoria que possui produtos ou serviços associados');
            }

            $this->categoriaRepository->delete($id);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function obterCaminhoAteRaiz($id)
    {
        return $this->categoriaRepository->obterCaminhoAteRaiz($id);
    }

    public function obterTodasSubcategorias($id)
    {
        return $this->categoriaRepository->obterTodasSubcategorias($id);
    }
}
