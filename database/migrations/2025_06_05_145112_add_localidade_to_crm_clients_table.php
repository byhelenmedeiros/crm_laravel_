<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocalidadeToCrmClientsTable extends Migration
{
    public function up()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            // Adiciona a coluna 'localidade' após, por exemplo, 'url'. Ajuste conforme preferir.
            $table->string('localidade')->nullable()->after('url');
        });
    }

    public function down()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->dropColumn('localidade');
        });
    }
}
