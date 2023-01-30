<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastEditionIdToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            Schema::table('orders', function (Blueprint $table) {
                //
                $table->integer('last_edition_id')->unsigned()->nullable();
                $table->integer('edited_total')->unsigned()->nullable();
            });
        });
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
            Schema::table('orders', function (Blueprint $table) {
                //
                $table->dropColumn('last_edition_id');
                $table->dropColumn('edited_total');
            });
        });
    }
}
