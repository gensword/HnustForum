<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('husers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('grade')->nullable();
            $table->string('major')->nullable();
            $table->text('resume')->nullable();
            $table->string('weixin')->nullable();
            $table->integer('vitality');
            $table->integer('followers');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('user_status_id');
            $table->engine = 'InnoDB';
        });

        Schema::table('husers', function (Blueprint $table){
            $table->index(['username', 'password']);
            $table->index('created_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('husers');
    }
}
