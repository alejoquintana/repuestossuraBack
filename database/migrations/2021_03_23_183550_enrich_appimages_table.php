<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnrichAppimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appimages', function (Blueprint $table) {
            $table->boolean('paused')->default(0);
            $table->boolean('all_pages')->default(0);
            $table->string('target_url')->nullable();
            $table->string('alt')->nullable();
            $table->string('name')->nullable()->change();
            $table->string('url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appimages', function (Blueprint $table) {
            //
            $table->dropColumn('paused');
            $table->dropColumn('all_pages');
            $table->dropColumn('target_url');
            $table->dropColumn('alt');
        });
    }
}
