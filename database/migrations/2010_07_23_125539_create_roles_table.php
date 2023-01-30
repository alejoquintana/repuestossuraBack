<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level')->unique();
            $table->string('name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

         // Insert some stuff
    DB::table('roles')->insert(
        array(
            'level' => 1,
            'name' => 'super'
        )
    );
    DB::table('roles')->insert(
        array(
            'level' => 2,
            'name' => 'admin'
        )
    );
    DB::table('roles')->insert(
        array(
            'level' => 3,
            'name' => 'reventa'
        )
    );
    DB::table('roles')->insert(
        array(
            'level' => 4,
            'name' => 'comercio'
        )
    );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
