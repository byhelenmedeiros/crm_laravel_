<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            // vendor_id como chave estrangeira para vendors.id
            $table->foreignId('vendor_id')
                  ->nullable()
                  ->constrained('vendors')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->dropConstrainedForeignId('vendor_id');
        });
    }
};
