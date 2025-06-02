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
        $table->string('nif', 9)->nullable()->after('name'); 
    });
}

public function down()
{
    Schema::table('crm_clients', function (Blueprint $table) {
        $table->dropColumn('nif');
    });
}
};
