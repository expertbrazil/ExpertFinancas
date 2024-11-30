<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ProdutoService;
use App\Services\CategoriaService;
use App\Repositories\ProdutoRepository;
use App\Repositories\CategoriaRepository;
use App\Enums\TipoProduto;
use App\Enums\StatusGeral;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Mockery;

class ProdutoServiceTest extends TestCase
{
    protected $produtoService;
    protected $produtoRepository;
    protected $categoriaRepository;
    protected $storage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->produtoRepository = Mockery::mock(ProdutoRepository::class);
        $this->categoriaRepository = Mockery::mock(CategoriaRepository::class);
        
        $this->produtoService = new ProdutoService(
            $this->produtoRepository,
            $this->categoriaRepository
        );

        Storage::fake('public');
        Cache::flush();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function deve_listar_produtos_com_cache()
    {
        $filtros = ['nome' => 'Teste'];
        $produtos = collect([
            ['id' => 1, 'nome' => 'Produto Teste']
        ]);

        $this->produtoRepository
            ->shouldReceive('listarComFiltros')
            ->once()
            ->with($filtros)
            ->andReturn($produtos);

        // Primeira chamada - deve buscar do repositório
        $resultado1 = $this->produtoService->listar($filtros);
        
        // Segunda chamada - deve buscar do cache
        $resultado2 = $this->produtoService->listar($filtros);

        $this->assertEquals($produtos, $resultado1);
        $this->assertEquals($produtos, $resultado2);
    }

    /** @test */
    public function deve_criar_produto_fisico_com_imagem()
    {
        $imagem = UploadedFile::fake()->image('produto.jpg');
        $dados = [
            'nome' => 'Produto Teste',
            'tipo' => TipoProduto::PRODUTO_FISICO->value,
            'categoria_id' => 1,
            'preco_custo' => '10.00',
            'preco_venda' => '20.00',
            'estoque' => 10,
            'status' => StatusGeral::ATIVO->value,
            'imagem' => $imagem
        ];

        $this->categoriaRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn((object)['id' => 1]);

        $this->produtoRepository
            ->shouldReceive('buscarPorSku')
            ->once()
            ->andReturnNull();

        $this->produtoRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn((object)array_merge($dados, ['id' => 1]));

        $produto = $this->produtoService->criar($dados);

        $this->assertEquals(1, $produto->id);
        $this->assertEquals('Produto Teste', $produto->nome);
        Storage::disk('public')->assertExists('produtos/' . $imagem->hashName());
    }

    /** @test */
    public function deve_atualizar_produto_com_novo_preco()
    {
        $id = 1;
        $dados = [
            'preco_venda' => '25.00',
            'status' => StatusGeral::ATIVO->value
        ];

        $produtoExistente = (object)[
            'id' => $id,
            'nome' => 'Produto Teste',
            'preco_venda' => '20.00'
        ];

        $this->produtoRepository
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($produtoExistente);

        $this->produtoRepository
            ->shouldReceive('update')
            ->once()
            ->andReturn((object)array_merge((array)$produtoExistente, $dados));

        $produto = $this->produtoService->atualizar($id, $dados);

        $this->assertEquals($id, $produto->id);
        $this->assertEquals('25.00', $produto->preco_venda);
    }

    /** @test */
    public function deve_excluir_produto_com_imagem()
    {
        $id = 1;
        $produto = (object)[
            'id' => $id,
            'nome' => 'Produto Teste',
            'imagem' => 'produtos/teste.jpg'
        ];

        Storage::disk('public')->put('produtos/teste.jpg', 'conteudo teste');

        $this->produtoRepository
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($produto);

        $this->produtoRepository
            ->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturn(true);

        $this->produtoService->excluir($id);

        Storage::disk('public')->assertMissing('produtos/teste.jpg');
    }

    /** @test */
    public function deve_atualizar_estoque_do_produto()
    {
        $id = 1;
        $quantidade = 5;
        $operacao = 'adicionar';

        $this->produtoRepository
            ->shouldReceive('atualizarEstoque')
            ->once()
            ->with($id, $quantidade, $operacao)
            ->andReturn(true);

        $resultado = $this->produtoService->atualizarEstoque($id, $quantidade, $operacao);

        $this->assertTrue($resultado);
    }

    /** @test */
    public function deve_lancar_excecao_ao_criar_produto_com_sku_duplicado()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('SKU já cadastrado');

        $dados = [
            'nome' => 'Produto Teste',
            'sku' => 'SKU123'
        ];

        $this->produtoRepository
            ->shouldReceive('buscarPorSku')
            ->once()
            ->with('SKU123')
            ->andReturn((object)['id' => 2, 'sku' => 'SKU123']);

        $this->produtoService->criar($dados);
    }

    /** @test */
    public function deve_buscar_produto_do_cache()
    {
        $id = 1;
        $produto = (object)[
            'id' => $id,
            'nome' => 'Produto Teste'
        ];

        $this->produtoRepository
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($produto);

        // Primeira chamada - deve buscar do repositório
        $resultado1 = $this->produtoService->buscar($id);
        
        // Segunda chamada - deve buscar do cache
        $resultado2 = $this->produtoService->buscar($id);

        $this->assertEquals($produto, $resultado1);
        $this->assertEquals($produto, $resultado2);
    }

    /** @test */
    public function deve_invalidar_cache_ao_atualizar_produto()
    {
        $id = 1;
        $dados = ['nome' => 'Novo Nome'];
        $produto = (object)array_merge(['id' => $id], $dados);

        // Armazena no cache
        Cache::put("produto_{$id}", $produto, 60);

        $this->produtoRepository
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($produto);

        $this->produtoRepository
            ->shouldReceive('update')
            ->once()
            ->andReturn($produto);

        $this->produtoService->atualizar($id, $dados);

        // Cache deve ter sido invalidado
        $this->assertNull(Cache::get("produto_{$id}"));
    }
}
