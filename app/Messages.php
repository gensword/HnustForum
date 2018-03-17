<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    public function fromUser(){
        return $this->belongsTo('App\Husers', 'from_uid');
    }

    public function toUser(){
        return $this->belongsTo('App\Husers', 'to_uid');
    }
}
