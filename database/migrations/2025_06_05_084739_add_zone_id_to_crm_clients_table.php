<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            // Cria a coluna zone_id referenciando zones.id
            $table->foreignId('zone_id')
                  ->nullable()
                  ->constrained('zones')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->dropConstrainedForeignId('zone_id');
        });
    }
};
