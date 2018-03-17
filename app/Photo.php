<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photo';

    public function user(){
        return $this->belongsTo('App\Husers', 'user_id');
    }
}
