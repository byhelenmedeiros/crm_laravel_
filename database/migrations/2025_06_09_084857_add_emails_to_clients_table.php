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
        $table->string('email1')->nullable()->after('telefone3');
        $table->string('email2')->nullable()->after('email1');
        $table->string('email3')->nullable()->after('email2');
    });
}

public function down()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->dropColumn(['email1', 'email2', 'email3']);
    });
}

};
