<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Despesas Administrativas
        $despesasAdmin = Categoria::create([
            'codigo' => '329',
            'nome' => 'Despesas Administrativas',
            'tipo' => 'despesa',
            'nivel' => 1,
            'ativo' => true
        ]);

        // Despesas com Pessoal
        $despesasPessoal = Categoria::create([
            'codigo' => '330',
            'nome' => 'Despesas com Pessoal',
            'tipo' => 'despesa',
            'nivel' => 1,
            'ativo' => true
        ]);

        // Subcategorias de Despesas com Pessoal
        $salarios = Categoria::create([
            'codigo' => '331',
            'nome' => 'SALÁRIOS E ORDENADOS',
            'tipo' => 'despesa',
            'categoria_pai_id' => $despesasPessoal->id,
            'nivel' => 2,
            'ativo' => true
        ]);

        $funcaoGratificada = Categoria::create([
            'codigo' => '333',
            'nome' => 'FUNÇÃO GRATIFICADA SECRETÁRIO',
            'tipo' => 'despesa',
            'categoria_pai_id' => $despesasPessoal->id,
            'nivel' => 2,
            'ativo' => true
        ]);

        // Adicionar mais subcategorias conforme necessário
        $descontosEmFolha = Categoria::create([
            'codigo' => '334',
            'nome' => 'Descontos em Folha',
            'tipo' => 'despesa',
            'categoria_pai_id' => $despesasPessoal->id,
            'nivel' => 2,
            'ativo' => true
        ]);

        // Receitas
        $receitasServicos = Categoria::create([
            'codigo' => '400',
            'nome' => 'Receitas com Serviços',
            'tipo' => 'receita',
            'nivel' => 1,
            'ativo' => true
        ]);

        $receitasHospedagem = Categoria::create([
            'codigo' => '401',
            'nome' => 'Hospedagem de Sites',
            'tipo' => 'receita',
            'categoria_pai_id' => $receitasServicos->id,
            'nivel' => 2,
            'ativo' => true
        ]);

        $receitasDesenvolvimento = Categoria::create([
            'codigo' => '402',
            'nome' => 'Desenvolvimento de Sistemas',
            'tipo' => 'receita',
            'categoria_pai_id' => $receitasServicos->id,
            'nivel' => 2,
            'ativo' => true
        ]);
    }
}
