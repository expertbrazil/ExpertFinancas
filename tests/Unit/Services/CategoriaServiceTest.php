<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\CategoriaService;
use App\Repositories\CategoriaRepository;
use App\Enums\TipoCategoria;
use App\Enums\StatusGeral;
use Illuminate\Support\Facades\Cache;
use Mockery;

class CategoriaServiceTest extends TestCase
{
    protected $categoriaService;
    protected $categoriaRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoriaRepository = Mockery::mock(CategoriaRepository::class);
        $this->categoriaService = new CategoriaService($this->categoriaRepository);

        Cache::flush();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function deve_listar_categorias_com_cache()
    {
        $filtros = ['nome' => 'Teste'];
        $categorias = collect([
            ['id' => 1, 'nome' => 'Categoria Teste']
        ]);

        $this->categoriaRepository
            ->shouldReceive('listarComFiltros')
            ->once()
            ->with($filtros)
            ->andReturn($categorias);

        // Primeira chamada - deve buscar do repositório
        $resultado1 = $this->categoriaService->listar($filtros);
        
        // Segunda chamada - deve buscar do cache
        $resultado2 = $this->categoriaService->listar($filtros);

        $this->assertEquals($categorias, $resultado1);
        $this->assertEquals($categorias, $resultado2);
    }

    /** @test */
    public function deve_criar_categoria_com_pai()
    {
        $dados = [
            'nome' => 'Subcategoria',
            'tipo' => TipoCategoria::PRODUTO->value,
            'categoria_pai_id' => 1,
            'status' => StatusGeral::ATIVO->value
        ];

        $categoriaPai = (object)[
            'id' => 1,
            'nome' => 'Categoria Pai',
            'nivel' => 1
        ];

        $this->categoriaRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($categoriaPai);

        $this->categoriaRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn((object)array_merge($dados, [
                'id' => 2,
                'nivel' => 2,
                'caminho' => '1.2'
            ]));

        $categoria = $this->categoriaService->criar($dados);

        $this->assertEquals(2, $categoria->id);
        $this->assertEquals(2, $categoria->nivel);
        $this->assertEquals('1.2', $categoria->caminho);
    }

    /** @test */
    public function deve_impedir_ciclo_em_hierarquia()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Operação criaria um ciclo na hierarquia');

        $categoriaA = (object)[
            'id' => 1,
            'caminho' => '1'
        ];

        $categoriaB = (object)[
            'id' => 2,
            'caminho' => '1.2'
        ];

        $dados = [
            'categoria_pai_id' => 2
        ];

        $this->categoriaRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($categoriaA);

        $this->categoriaRepository
            ->shouldReceive('find')
            ->once()
            ->with(2)
            ->andReturn($categoriaB);

        $this->categoriaService->atualizar(1, $dados);
    }

    /** @test */
    public function deve_atualizar_subcategorias_ao_mover()
    {
        $categoriaOriginal = (object)[
            'id' => 2,
            'caminho' => '1.2',
            'nivel' => 2
        ];

        $novoPai = (object)[
            'id' => 3,
            'caminho' => '3',
            'nivel' => 1
        ];

        $subcategorias = collect([
            (object)[
                'id' => 4,
                'caminho' => '1.2.4',
                'nivel' => 3
            ],
            (object)[
                'id' => 5,
                'caminho' => '1.2.4.5',
                'nivel' => 4
            ]
        ]);

        $dados = [
            'categoria_pai_id' => 3
        ];

        $this->categoriaRepository
            ->shouldReceive('find')
            ->with(2)
            ->andReturn($categoriaOriginal);

        $this->categoriaRepository
            ->shouldReceive('find')
            ->with(3)
            ->andReturn($novoPai);

        $this->categoriaRepository
            ->shouldReceive('buscarSubcategorias')
            ->with(2)
            ->andReturn($subcategorias);

        $this->categoriaRepository
            ->shouldReceive('update')
            ->times(3)
            ->andReturn((object)['success' => true]);

        $resultado = $this->categoriaService->atualizar(2, $dados);

        $this->assertTrue($resultado->success);
    }

    /** @test */
    public function deve_excluir_categoria_sem_dependencias()
    {
        $id = 1;
        $categoria = (object)[
            'id' => $id,
            'nome' => 'Categoria Teste'
        ];

        $this->categoriaRepository
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($categoria);

        $this->categoriaRepository
            ->shouldReceive('temDependencias')
            ->once()
            ->with($id)
            ->andReturn(false);

        $this->categoriaRepository
            ->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturn(true);

        $this->categoriaService->excluir($id);
    }

    /** @test */
    public function deve_impedir_exclusao_com_dependencias()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Categoria possui dependências');

        $id = 1;
        $categoria = (object)[
            'id' => $id,
            'nome' => 'Categoria Teste'
        ];

        $this->categoriaRepository
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($categoria);

        $this->categoriaRepository
            ->shouldReceive('temDependencias')
            ->once()
            ->with($id)
            ->andReturn(true);

        $this->categoriaService->excluir($id);
    }

    /** @test */
    public function deve_buscar_categoria_do_cache()
    {
        $id = 1;
        $categoria = (object)[
            'id' => $id,
            'nome' => 'Categoria Teste'
        ];

        $this->categoriaRepository
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($categoria);

        // Primeira chamada - deve buscar do repositório
        $resultado1 = $this->categoriaService->buscar($id);
        
        // Segunda chamada - deve buscar do cache
        $resultado2 = $this->categoriaService->buscar($id);

        $this->assertEquals($categoria, $resultado1);
        $this->assertEquals($categoria, $resultado2);
    }

    /** @test */
    public function deve_listar_categorias_para_select()
    {
        $categorias = collect([
            (object)['id' => 1, 'nome' => 'Categoria A', 'nivel' => 1],
            (object)['id' => 2, 'nome' => 'Subcategoria B', 'nivel' => 2]
        ]);

        $this->categoriaRepository
            ->shouldReceive('listarHierarquia')
            ->once()
            ->andReturn($categorias);

        $resultado = $this->categoriaService->listarParaSelect();

        $this->assertEquals($categorias, $resultado);
    }
}
