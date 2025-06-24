<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorZonaZonacomercialToCrmClientsTable extends Migration
{
    public function up()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            // Vendedor e Zona armazenamos como string (por enquanto)
            $table->string('vendedor')->nullable()->after('url');
            $table->string('zona')->nullable()->after('vendor');
            // Zona Comercial: armazenamento como ENUM ajuda a limitar aos valores permitidos
            $table->enum('zona_comercial', ['Norte','Sul','Centro','Ilhas'])
                  ->nullable()
                  ->after('zona');
        });
    }

    public function down()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->dropColumn(['vendor','zona','zona_comercial']);
        });
    }
}
