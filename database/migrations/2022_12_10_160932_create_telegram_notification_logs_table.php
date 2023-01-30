<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramNotificationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_notification_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ok')->nullable();
            $table->string('chat_id')->nullable();
            $table->string('message')->nullable();
            $table->string('user_token')->nullable();
            $table->string('update_id')->nullable();
            $table->text('body')->nullable();
            $table->json('json_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegram_notification_logs');
    }
}
