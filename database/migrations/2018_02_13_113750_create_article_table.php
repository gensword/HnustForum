<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_status_id');
            $table->integer('article_category_id');
            $table->integer('user_id')->unsigned();
            $table->text('title');
            $table->text('content');
            $table->integer('votes_total');
            $table->integer('comments_total');
            $table->integer('read_total');
            $table->integer('isDraft');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('article', function(Blueprint $table){
            $table->index('created_at');
            $table->index(['article_category_id', 'votes_total']);
            $table->index(['article_category_id', 'comments_total']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
