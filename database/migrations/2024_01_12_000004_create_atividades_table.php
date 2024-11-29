<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->text('detalhes')->nullable();
            $table->string('tipo');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->string('entidade_tipo');
            $table->unsignedBigInteger('entidade_id');
            $table->timestamps();

            $table->index(['entidade_tipo', 'entidade_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atividades');
    }
};
