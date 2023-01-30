<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('area_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('nombre_fantasia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('area_code');
            $table->dropColumn('phone');
            $table->dropColumn('razon_social');
            $table->dropColumn('nombre_fantasia');
        });
    }
}
