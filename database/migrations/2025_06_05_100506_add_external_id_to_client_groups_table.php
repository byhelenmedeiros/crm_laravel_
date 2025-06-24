<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adiciona a coluna external_id na tabela client_groups.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_groups', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     * Remove a coluna external_id.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_groups', function (Blueprint $table) {
            $table->dropColumn('external_id');
        });
    }
};
