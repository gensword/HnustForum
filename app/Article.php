<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Article extends Model
{
    use SearchableTrait;

    protected $table = 'article';

    protected $searchable = [
        'columns' => [
            'husers.username' => 2,
            'husers.avatar' => 2,
            'article.title' => 10,
            'article.content' => 8,
        ],
        'joins' => ['husers' => ['husers.id', 'article.user_id'],
        ]];

    public function user(){
        return $this->belongsTo('App\Husers');
    }

    public function vote(){
        return $this->hasMany('App\Vote', 'article_id');
    }

    public function comments(){
        return $this->hasMany('App\Comments', 'article_id');
    }
}
