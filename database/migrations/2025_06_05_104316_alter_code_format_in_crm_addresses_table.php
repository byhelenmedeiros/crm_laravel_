<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCodeFormatInCrmAddressesTable extends Migration
{
    /**
     * Rodar as migrations.
     */
    public function up(): void
    {
        // Atenção: para usar ->change() em colunas existentes, é preciso do doctrine/dbal:
        // composer require doctrine/dbal
        Schema::table('crm_addresses', function (Blueprint $table) {
            // Ajusta para string de tamanho 8 ("1234-567" = 8 caracteres)
            $table->string('code', 8)->nullable()->change();
        });
    }

    /**
     * Reverter as migrations.
     */
    public function down(): void
    {
        Schema::table('crm_addresses', function (Blueprint $table) {
            // Caso antes fosse VARCHAR(255) ou outro tamanho, retorne ao tamanho original
            $table->string('code', 255)->nullable()->change();
        });
    }
}
