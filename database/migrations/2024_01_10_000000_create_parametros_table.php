<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Cria a tabela se não existir
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->string('nome_sistema')->default('Expert Finanças');
            $table->string('logo_path')->nullable();
            $table->string('cor_primaria')->default('#0d6efd');
            $table->string('cor_secundaria')->default('#6c757d');
            $table->string('cor_fundo')->default('#ffffff');
            $table->string('cor_texto')->default('#212529');
            $table->string('cor_navbar')->default('#212529');
            $table->string('cor_footer')->default('#212529');
            $table->string('email_contato')->nullable();
            $table->string('telefone_contato')->nullable();
            $table->text('texto_rodape')->nullable();
            $table->timestamps();
        });

        // Insere o registro inicial
        DB::table('parametros')->insert([
            'nome_sistema' => 'Expert Finanças',
            'cor_primaria' => '#0d6efd',
            'cor_secundaria' => '#6c757d',
            'cor_fundo' => '#ffffff',
            'cor_texto' => '#212529',
            'cor_navbar' => '#212529',
            'cor_footer' => '#212529',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('parametros');
    }
};
