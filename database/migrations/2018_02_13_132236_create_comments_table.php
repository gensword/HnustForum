<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid');
            $table->integer('users_id')->unsigned();
            $table->integer('article_id')->unsigned();
            $table->text('content');
            $table->integer('votes_total');
            $table->timestamps();
        });

        Schema::table('comments', function (Blueprint $table){

           $table->index(['article_id', 'created_at']);
           $table->index(['article_id', 'votes_total']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
