<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('external_id')->unique();
            $table->string('name', 60);
            $table->timestamps();

            // índice secundário em name (otimiza buscas por nome de zona)
            $table->index('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('zones');
    }
};
