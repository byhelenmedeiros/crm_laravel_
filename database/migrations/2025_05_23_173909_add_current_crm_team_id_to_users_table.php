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
    Schema::table('users', function (Blueprint $table) {
        // Adiciona a chave estrangeira
        $table->unsignedBigInteger('current_crm_team_id')->nullable();
        
        // Define o relacionamento com a tabela crm_teams
        $table->foreign('current_crm_team_id')->references('id')->on('crm_teams')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['current_crm_team_id']);
        $table->dropColumn('current_crm_team_id');
    });
}

};
