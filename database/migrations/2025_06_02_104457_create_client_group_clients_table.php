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
        Schema::create('client_group_clients', function (Blueprint $table) {
            $table->id();
            // Referência correta à tabela crm_clients e à sua coluna id
            $table->foreignId('client_id')->constrained('crm_clients', 'id')->onDelete('cascade'); 
            // Relacionamento com a tabela group_subdivisions
            $table->foreignId('group_subdivision_id')->constrained('group_subdivisions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_group_clients');
    }   
};
