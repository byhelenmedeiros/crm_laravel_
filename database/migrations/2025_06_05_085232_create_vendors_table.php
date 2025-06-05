<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('external_id')->unique();
            $table->string('name', 100); // nome do vendor em inglês (até 100 chars)
            $table->timestamps();

            // índice secundário em name para eventual pesquisa
            $table->index('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
