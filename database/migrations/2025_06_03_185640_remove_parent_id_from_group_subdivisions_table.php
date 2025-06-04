<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('group_subdivisions', function (Blueprint $table) {
            if (Schema::hasColumn('group_subdivisions', 'parent_id')) {
                // Remove a foreign key antes de excluir a coluna
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('group_subdivisions', function (Blueprint $table) {
            if (! Schema::hasColumn('group_subdivisions', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('client_group_id');
            }
        });
    }
};
