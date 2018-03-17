<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'vote';

    public function user(){
        return $this->belongsTo('App\Husers', 'user_id');
    }

    public function article(){
        return $this->belongsTo('App\Article', 'article_id');
    }
}
