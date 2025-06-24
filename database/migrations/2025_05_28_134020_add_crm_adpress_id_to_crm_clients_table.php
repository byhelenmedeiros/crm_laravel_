<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('crm_clients', function (Blueprint $table) {
        $table->unsignedBigInteger('crm_adpress_id')->nullable();

        // Adicionando uma chave estrangeira para garantir integridade referencial com a tabela crm_addresses
        $table->foreign('crm_adpress_id')->references('id')->on('crm_addresses')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('crm_clients', function (Blueprint $table) {
        $table->dropForeign(['crm_adpress_id']);
        $table->dropColumn('crm_adpress_id');
    });
}

};
