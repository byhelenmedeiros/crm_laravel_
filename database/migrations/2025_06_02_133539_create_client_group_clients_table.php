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
        Schema::create('crm_clients', function (Blueprint $table) {
            $table->id(); // ID do cliente
            $table->foreignId('client_group_id')->constrained('client_groups')->onDelete('cascade'); // Relacionamento com client_groups
            $table->foreignId('group_subdivision_id')->nullable()->constrained('group_subdivisions')->onDelete('cascade'); // Relacionamento com group_subdivisions
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_clients');
    }
};
