<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->string('status')->default('aberto'); // aberto, em_andamento, fechado
            $table->string('prioridade')->default('media'); // baixa, media, alta
            $table->string('categoria');
            $table->timestamps();
        });

        Schema::create('ticket_respostas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('resposta');
            $table->boolean('is_staff')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_respostas');
        Schema::dropIfExists('tickets');
    }
};
