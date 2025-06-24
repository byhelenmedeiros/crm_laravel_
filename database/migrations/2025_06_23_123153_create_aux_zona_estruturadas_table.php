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
       Schema::create('aux_zona_estruturadas', function (Blueprint $table) {
    $table->id();
    $table->string('codigo_postal_inicio', 4)->comment('Prefixo do código postal');
    $table->string('nome_zona');
    $table->string('nome_zona_comercial');
    $table->string('nome_vendedor');
    $table->string('email_vendedor')->nullable();
    $table->string('telemovel_vendedor')->nullable();
    $table->integer('order')->default(0);
    $table->boolean('active')->default(true);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aux_zona_estruturadas');
    }
};
