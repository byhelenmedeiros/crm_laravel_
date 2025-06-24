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
        Schema::create('aux_client_group_subdivisions', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Nome da subdivisão
    $table->unsignedBigInteger('group_id'); // Ligação ao grupo principal
    $table->integer('order')->default(0);
    $table->boolean('active')->default(true);
    $table->timestamps();

    $table->foreign('group_id')->references('id')->on('aux_client_groups')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aux_client_group_subdivisions');
    }
};
