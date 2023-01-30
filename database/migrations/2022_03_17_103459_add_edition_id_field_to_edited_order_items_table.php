<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditionIdFieldToEditedOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edited_order_items', function (Blueprint $table) {
            //
            $table->integer('edition_id')->unsigned();
            $table->foreign('edition_id')->references('id')->on('order_editions');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('edited_order_items', function (Blueprint $table) {
            //
            $table->dropColumn('edition_id');
        });
    }
}
