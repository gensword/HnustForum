<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->integer('from_uid')->unsigned();
            $table->integer('to_uid')->unsigned();
            $table->integer('talk_id');
            $table->integer('read_status_id');
            $table->timestamps();
        });

        Schema::table('messages', function (Blueprint $table){
           $table->index('created_at');
            $table->index('talk_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
