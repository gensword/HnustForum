<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->integer('to_uid')->unsigned();
            $table->integer('read_status_id');
            $table->timestamps();
        });

        Schema::table('notification', function (Blueprint $table){
           $table->index('created_at');
           $table->index(['to_uid', 'read_status_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
}
