<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('plano_id')->constrained('planos')->onDelete('restrict');
            $table->boolean('status')->default(true);
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->decimal('valor', 10, 2);
            $table->integer('dia_vencimento');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assinaturas');
    }
};
