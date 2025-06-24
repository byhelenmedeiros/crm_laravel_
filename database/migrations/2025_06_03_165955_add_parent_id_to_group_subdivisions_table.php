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
        Schema::table('group_subdivisions', function (Blueprint $table) {
            // Adiciona a coluna parent_id (pode ficar nula) após client_group_id
            $table->unsignedBigInteger('parent_id')
                  ->nullable()
                  ->after('client_group_id');

            // Define a foreign key apontando para a própria tabela (auto‐referência)
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('group_subdivisions')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_subdivisions', function (Blueprint $table) {
            // Primeiro removemos a constraint de foreign key, depois a coluna
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
