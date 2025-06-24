<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('client_groups_clients', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('id')->unique();
        });
    }

    public function down()
    {
        Schema::table('client_groups_clients', function (Blueprint $table) {
            $table->dropColumn('external_id');
        });
    }
};
