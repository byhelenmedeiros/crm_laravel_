<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('group_subdivisions', function (Blueprint $table) {
            // Se ainda não existir a coluna parent_id, criaremos agora:
            if (! Schema::hasColumn('group_subdivisions', 'parent_id')) {
                // 1) Adiciona a coluna parent_id (nullable), logo após client_group_id
                $table->unsignedBigInteger('parent_id')
                      ->nullable()
                      ->after('client_group_id');

                // 2) Define a foreign key autorreferenciada
                $table->foreign('parent_id')
                      ->references('id')
                      ->on('group_subdivisions')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('group_subdivisions', function (Blueprint $table) {
            if (Schema::hasColumn('group_subdivisions', 'parent_id')) {
                // Remover primeiro a FK, depois a coluna
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
        });
    }
};
