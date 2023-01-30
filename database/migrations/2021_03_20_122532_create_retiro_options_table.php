<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRetiroOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        DB::table('retiro_options')->insert(
            array(
                'id' => 1,
                'code' => 'envio',
                'name' => 'Envío por transporte',
            )
        );
        DB::table('retiro_options')->insert(
            array(
                'id' => 2,
                'code' => 'deposito',
                'name' => 'Retiro en depósito',
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
        Schema::dropIfExists('retiro_options');
    }
}
