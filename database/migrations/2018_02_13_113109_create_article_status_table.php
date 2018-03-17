<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
            $table->string('description');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('article_status', function(Blueprint $table){
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_status');
    }
}
