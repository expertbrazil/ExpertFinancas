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
        Schema::create('planos_hospedagem', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('valor', 10, 2);
            $table->enum('periodo', ['mensal', 'trimestral', 'semestral', 'anual']);
            $table->integer('espaco_disco')->comment('em MB');
            $table->integer('largura_banda')->comment('em MB');
            $table->integer('contas_email');
            $table->integer('bancos_dados');
            $table->boolean('ssl_gratuito')->default(false);
            $table->boolean('backup_diario')->default(false);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planos_hospedagem');
    }
};
