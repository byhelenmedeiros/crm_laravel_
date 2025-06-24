<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnAndFixForeignKeyInCrmClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Primeiro, remover a chave estrangeira
        Schema::table('crm_clients', function (Blueprint $table) {
            // Substitua 'crm_adpress_id_foreign' pelo nome da sua chave estrangeira
            $table->dropForeign(['crm_adpress_id']); 
        });

        // Agora, renomear a coluna
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->renameColumn('crm_addpress_id', 'new_crm_adpress_id');
        });

        // Adicionar a chave estrangeira novamente com a nova coluna
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->foreign('new_crm_addresses_id')->references('id')->on('crm_adpress')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remover a chave estrangeira da nova coluna
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->dropForeign(['new_crm_adpress_id']);
        });

        // Renomear a coluna de volta para o nome antigo
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->renameColumn('new_crm_addresses_id', 'crm_adpress_id');
        });

        // Recriar a chave estrangeira associando ao nome original da coluna
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->foreign('crm_adpress_id')->references('id')->on('crm_address')->onDelete('cascade');
        });
    }
}
