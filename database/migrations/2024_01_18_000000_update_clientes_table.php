<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Removendo colunas antigas
            $table->dropColumn([
                'telefone_comercial',
                'email_financeiro',
                'email_administrativo'
            ]);

            // Adicionando novas colunas
            $table->string('email')->nullable()->after('uf');
            $table->string('telefone', 15)->nullable()->after('email');
            $table->string('celular', 15)->nullable()->after('telefone');
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Removendo novas colunas
            $table->dropColumn(['email', 'telefone', 'celular']);

            // Restaurando colunas antigas
            $table->string('telefone_comercial', 20);
            $table->string('email_financeiro');
            $table->string('email_administrativo');
        });
    }
};
