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
        Schema::create('contas_receber', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->date('data_vencimento');
            $table->date('data_recebimento')->nullable();
            $table->enum('status', ['pendente', 'pago', 'cancelado'])->default('pendente');
            $table->foreignId('cliente_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('categoria_id')->nullable()->constrained()->onDelete('set null');
            $table->string('forma_recebimento')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas_receber');
    }
};
