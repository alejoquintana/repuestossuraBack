<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddRetiroIdFieldToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            
            $table->integer('retiro_id')->unsigned()->nullable();
            $table->foreign('retiro_id')->references('id')->on('retiro_options');
            
        });

        DB::update('update orders set retiro_id = 1 where shipping = 1');
        DB::update('update orders set retiro_id = 2 where shipping = 0');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropIfExists('retiro_id');
        });
    }
}
