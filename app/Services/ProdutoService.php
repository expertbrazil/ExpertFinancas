<?php

namespace App\Services;

use App\Repositories\ProdutoRepository;
use App\Repositories\CategoriaRepository;
use App\Traits\UploadTrait;
use App\Traits\CacheTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProdutoService
{
    use UploadTrait, CacheTrait;

    protected $produtoRepository;
    protected $categoriaRepository;

    public function __construct(
        ProdutoRepository $produtoRepository,
        CategoriaRepository $categoriaRepository
    ) {
        $this->produtoRepository = $produtoRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->setCachePrefix('produto');
    }

    public function listar($filtros = [])
    {
        return $this->remember(
            $this->getFiltersCacheKey($filtros, 'lista'),
            fn() => $this->produtoRepository->listarComFiltros($filtros),
            30 // cache por 30 minutos
        );
    }

    public function criar(array $dados)
    {
        DB::beginTransaction();
        try {
            // Verifica se a categoria existe
            if (isset($dados['categoria_id'])) {
                $this->categoriaRepository->find($dados['categoria_id']);
            }

            // Verifica duplicidade de SKU
            if (isset($dados['sku']) && $this->produtoRepository->buscarPorSku($dados['sku'])) {
                throw new \Exception('SKU já cadastrado');
            }

            // Upload de imagem se existir
            if (isset($dados['imagem']) && $dados['imagem']) {
                $dados['imagem'] = $this->uploadFile($dados['imagem'], 'produtos');
            }

            // Formata valores monetários
            if (isset($dados['preco'])) {
                $dados['preco'] = str_replace(['R$', '.', ','], ['', '', '.'], $dados['preco']);
            }

            $produto = $this->produtoRepository->create($dados);
            
            // Invalida caches relacionados
            $this->invalidateProdutoCache($produto->id);
            
            DB::commit();
            return $produto;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar produto', [
                'erro' => $e->getMessage(),
                'dados' => $dados
            ]);
            throw $e;
        }
    }

    public function atualizar($id, array $dados)
    {
        DB::beginTransaction();
        try {
            $produto = $this->produtoRepository->find($id);

            // Verifica se a categoria existe
            if (isset($dados['categoria_id'])) {
                $this->categoriaRepository->find($dados['categoria_id']);
            }

            // Verifica duplicidade de SKU
            if (isset($dados['sku'])) {
                $existente = $this->produtoRepository->buscarPorSku($dados['sku']);
                if ($existente && $existente->id !== $id) {
                    throw new \Exception('SKU já cadastrado');
                }
            }

            // Upload de nova imagem se existir
            if (isset($dados['imagem']) && $dados['imagem']) {
                if ($produto->imagem) {
                    $this->deleteFile($produto->imagem);
                }
                $dados['imagem'] = $this->uploadFile($dados['imagem'], 'produtos');
            }

            // Formata valores monetários
            if (isset($dados['preco'])) {
                $dados['preco'] = str_replace(['R$', '.', ','], ['', '', '.'], $dados['preco']);
            }

            $produto = $this->produtoRepository->update($id, $dados);
            
            // Invalida caches relacionados
            $this->invalidateProdutoCache($id);
            
            DB::commit();
            return $produto;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar produto', [
                'erro' => $e->getMessage(),
                'id' => $id,
                'dados' => $dados
            ]);
            throw $e;
        }
    }

    public function excluir($id)
    {
        DB::beginTransaction();
        try {
            $produto = $this->produtoRepository->find($id);
            
            // Remove imagem se existir
            if ($produto->imagem) {
                $this->deleteFile($produto->imagem);
            }

            $this->produtoRepository->delete($id);
            
            // Invalida caches relacionados
            $this->invalidateProdutoCache($id);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir produto', [
                'erro' => $e->getMessage(),
                'id' => $id
            ]);
            throw $e;
        }
    }

    public function atualizarEstoque($id, $quantidade, $operacao = 'adicionar')
    {
        try {
            $resultado = $this->produtoRepository->atualizarEstoque($id, $quantidade, $operacao);
            
            // Invalida caches relacionados
            $this->invalidateProdutoCache($id);
            
            return $resultado;
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar estoque', [
                'erro' => $e->getMessage(),
                'id' => $id,
                'quantidade' => $quantidade,
                'operacao' => $operacao
            ]);
            throw $e;
        }
    }

    public function buscar($id)
    {
        return $this->remember(
            "produto_{$id}",
            fn() => $this->produtoRepository->find($id),
            60 // cache por 1 hora
        );
    }

    public function buscarPorSku($sku)
    {
        return $this->remember(
            "produto_sku_{$sku}",
            fn() => $this->produtoRepository->buscarPorSku($sku),
            60 // cache por 1 hora
        );
    }

    protected function invalidateProdutoCache($id): void
    {
        // Invalida cache específico do produto
        $this->forget("produto_{$id}");
        
        // Invalida caches de listagens
        $this->forgetByTags(['produtos', "produto_{$id}"]);
        
        // Invalida cache de SKU se existir
        if ($sku = $this->produtoRepository->find($id)?->sku) {
            $this->forget("produto_sku_{$sku}");
        }
    }
}
