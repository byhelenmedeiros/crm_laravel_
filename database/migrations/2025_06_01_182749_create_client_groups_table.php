<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClientGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('client_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Inserir os grupos iniciais já no up()
        DB::table('client_groups')->insert([
            ['id' => 1, 'name' => 'Sports Stores'],
            ['id' => 2, 'name' => 'Clubs'],
            ['id' => 3, 'name' => 'Foreigners'],
            ['id' => 4, 'name' => 'Sponsors'],
            ['id' => 5, 'name' => 'Player'],
            ['id' => 6, 'name' => 'City Councils / Parishes'],
            ['id' => 7, 'name' => 'Event Organizers'],
            ['id' => 8, 'name' => 'Gifts'],
            ['id' => 9, 'name' => 'Resellers'],
            ['id' => 10, 'name' => 'Companies'],
            ['id' => 11, 'name' => 'Education'],
            ['id' => 12, 'name' => 'Goalkeeper'],
            ['id' => 13, 'name' => 'End Consumer'],
            ['id' => 14, 'name' => 'Coach / Manager'],
            ['id' => 15, 'name' => 'Federations'],
            ['id' => 16, 'name' => 'Physiotherapist'],
            ['id' => 17, 'name' => 'Gym'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('client_groups');
    }
}
