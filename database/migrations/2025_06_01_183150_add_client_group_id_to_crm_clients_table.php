<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('crm_clients', function (Blueprint $table) {
        $table->foreignId('client_group_id')->nullable()->constrained('client_groups')->after('nif');
    });
}

public function down()
{
    Schema::table('crm_clients', function (Blueprint $table) {
        $table->dropForeign(['client_group_id']);
        $table->dropColumn('client_group_id');
    });
}

};
