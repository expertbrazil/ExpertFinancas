<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_pessoa', ['PF', 'PJ']);
            $table->boolean('status')->default(true);
            $table->string('nome_completo')->nullable();
            $table->string('cpf', 14)->nullable()->unique();
            $table->date('data_nascimento')->nullable();
            $table->string('razao_social')->nullable();
            $table->string('cnpj', 18)->nullable()->unique();
            $table->date('data_fundacao')->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('telefone_comercial', 20);
            $table->string('email_financeiro');
            $table->string('email_administrativo');
            $table->timestamps();
            
            // Índices para melhor performance
            $table->index('tipo_pessoa');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
