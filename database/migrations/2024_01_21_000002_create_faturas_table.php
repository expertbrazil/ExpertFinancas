<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('restrict');
            $table->foreignId('assinatura_id')->constrained('assinaturas')->onDelete('restrict');
            $table->string('numero')->unique();
            $table->decimal('valor', 10, 2);
            $table->date('data_emissao');
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->string('status')->default('pendente'); // pendente, pago, vencido, cancelado
            $table->string('url_boleto')->nullable();
            $table->string('linha_digitavel')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faturas');
    }
};
