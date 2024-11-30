<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Services\ProdutoService;
use App\Services\CategoriaService;
use App\Enums\TipoProduto;
use App\Enums\StatusGeral;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $produtoService;
    protected $categoriaService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->produtoService = Mockery::mock(ProdutoService::class);
        $this->categoriaService = Mockery::mock(CategoriaService::class);
        
        $this->app->instance(ProdutoService::class, $this->produtoService);
        $this->app->instance(CategoriaService::class, $this->categoriaService);

        Storage::fake('public');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function index_deve_exibir_lista_de_produtos()
    {
        $filtros = ['nome' => 'Teste'];
        $produtos = collect([
            (object)[
                'id' => 1,
                'nome' => 'Produto Teste',
                'preco_venda' => 20.00,
                'status' => StatusGeral::ATIVO->value
            ]
        ]);

        $categorias = collect([
            (object)['id' => 1, 'nome' => 'Categoria Teste']
        ]);

        $this->produtoService
            ->shouldReceive('listar')
            ->once()
            ->with(Mockery::subset($filtros))
            ->andReturn($produtos);

        $this->categoriaService
            ->shouldReceive('listarParaSelect')
            ->once()
            ->andReturn($categorias);

        $response = $this->get(route('produtos.index', $filtros));

        $response->assertStatus(200)
            ->assertViewIs('produtos.index')
            ->assertViewHas('produtos', $produtos)
            ->assertViewHas('categorias', $categorias)
            ->assertSee('Produto Teste');
    }

    /** @test */
    public function create_deve_exibir_formulario()
    {
        $categorias = collect([
            (object)['id' => 1, 'nome' => 'Categoria Teste']
        ]);

        $this->categoriaService
            ->shouldReceive('listarParaSelect')
            ->once()
            ->andReturn($categorias);

        $response = $this->get(route('produtos.create'));

        $response->assertStatus(200)
            ->assertViewIs('produtos.create')
            ->assertViewHas('categorias', $categorias)
            ->assertViewHas('status_list');
    }

    /** @test */
    public function store_deve_criar_produto()
    {
        $dados = [
            'nome' => 'Novo Produto',
            'tipo' => TipoProduto::PRODUTO_FISICO->value,
            'categoria_id' => 1,
            'preco_custo' => '10.00',
            'preco_venda' => '20.00',
            'estoque' => 10,
            'status' => StatusGeral::ATIVO->value,
            'imagem' => UploadedFile::fake()->image('produto.jpg')
        ];

        $produtoCriado = (object)array_merge($dados, ['id' => 1]);

        $this->produtoService
            ->shouldReceive('criar')
            ->once()
            ->with(Mockery::subset($dados))
            ->andReturn($produtoCriado);

        $response = $this->post(route('produtos.store'), $dados);

        $response->assertRedirect(route('produtos.index'))
            ->assertSessionHas('success');
    }

    /** @test */
    public function update_deve_atualizar_produto()
    {
        $id = 1;
        $dados = [
            'nome' => 'Produto Atualizado',
            'tipo' => TipoProduto::PRODUTO_FISICO->value,
            'categoria_id' => 1,
            'preco_venda' => '25.00',
            'status' => StatusGeral::ATIVO->value
        ];

        $produtoAtualizado = (object)array_merge($dados, ['id' => $id]);

        $this->produtoService
            ->shouldReceive('atualizar')
            ->once()
            ->with($id, Mockery::subset($dados))
            ->andReturn($produtoAtualizado);

        $response = $this->put(route('produtos.update', $id), $dados);

        $response->assertRedirect(route('produtos.index'))
            ->assertSessionHas('success');
    }

    /** @test */
    public function destroy_deve_excluir_produto()
    {
        $id = 1;

        $this->produtoService
            ->shouldReceive('excluir')
            ->once()
            ->with($id)
            ->andReturn(true);

        $response = $this->delete(route('produtos.destroy', $id));

        $response->assertRedirect(route('produtos.index'))
            ->assertSessionHas('success');
    }

    /** @test */
    public function store_deve_validar_campos_obrigatorios()
    {
        $response = $this->post(route('produtos.store'), []);

        $response->assertSessionHasErrors([
            'nome',
            'categoria_id',
            'preco_custo',
            'preco_venda',
            'estoque',
            'status'
        ]);
    }

    /** @test */
    public function update_deve_rejeitar_preco_invalido()
    {
        $id = 1;
        $dados = [
            'nome' => 'Produto Teste',
            'preco_venda' => 'preco_invalido'
        ];

        $response = $this->put(route('produtos.update', $id), $dados);

        $response->assertSessionHasErrors('preco_venda');
    }

    /** @test */
    public function atualizarEstoque_deve_atualizar_quantidade()
    {
        $id = 1;
        $dados = [
            'quantidade' => 5,
            'operacao' => 'adicionar'
        ];

        $this->produtoService
            ->shouldReceive('atualizarEstoque')
            ->once()
            ->with($id, $dados['quantidade'], $dados['operacao'])
            ->andReturn(true);

        $response = $this->post(route('produtos.atualizar-estoque', $id), $dados);

        $response->assertSessionHas('success');
    }

    /** @test */
    public function show_deve_exibir_detalhes_do_produto()
    {
        $id = 1;
        $produto = (object)[
            'id' => $id,
            'nome' => 'Produto Teste',
            'preco_venda' => 20.00,
            'status' => StatusGeral::ATIVO->value
        ];

        $this->produtoService
            ->shouldReceive('buscar')
            ->once()
            ->with($id)
            ->andReturn($produto);

        $response = $this->get(route('produtos.show', $id));

        $response->assertStatus(200)
            ->assertViewIs('produtos.show')
            ->assertViewHas('produto', $produto)
            ->assertSee('Produto Teste');
    }

    /** @test */
    public function edit_deve_exibir_formulario_com_dados()
    {
        $id = 1;
        $produto = (object)[
            'id' => $id,
            'nome' => 'Produto Teste',
            'preco_venda' => 20.00,
            'status' => StatusGeral::ATIVO->value
        ];

        $categorias = collect([
            (object)['id' => 1, 'nome' => 'Categoria Teste']
        ]);

        $this->produtoService
            ->shouldReceive('buscar')
            ->once()
            ->with($id)
            ->andReturn($produto);

        $this->categoriaService
            ->shouldReceive('listarParaSelect')
            ->once()
            ->andReturn($categorias);

        $response = $this->get(route('produtos.edit', $id));

        $response->assertStatus(200)
            ->assertViewIs('produtos.edit')
            ->assertViewHas('produto', $produto)
            ->assertViewHas('categorias', $categorias)
            ->assertSee('Produto Teste');
    }
}
