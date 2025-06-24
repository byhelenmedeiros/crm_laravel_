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
    Schema::table('crm_contacts', function (Blueprint $table) {
        $table->text('nome_do_presidente')->nullable();
    });
}

public function down()
{
    Schema::table('crm_contacts', function (Blueprint $table) {
        $table->dropColumn('nome_do_presidente');
    });
}

};
