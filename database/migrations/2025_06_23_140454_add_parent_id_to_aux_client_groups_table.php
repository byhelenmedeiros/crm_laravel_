<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::table('aux_client_groups', function (Blueprint $table) {
$table->unsignedBigInteger('group_subdivision_id')->nullable(); 

        $table->foreign('parent_id')
              ->references('id')
              ->on('aux_client_groups')
              ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('aux_client_groups', function (Blueprint $table) {
        $table->dropForeign(['parent_id']);
        $table->dropColumn('parent_id');
    });
}

};
