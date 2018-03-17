<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;



class Husers extends Authenticatable
{

    use Notifiable;
    use SearchableTrait;


    protected $fillable = [
        'username', 'email', 'password', 'vitality', 'user_status_id', 'avatar'
    ];

    protected $table = 'husers';

    protected $searchable = [
        'columns' => [
            'husers.username' => 8,
            'husers.id' => 5,
        ]];


    public function articles(){
        return $this->hasMany('App\article', 'user_id');
    }

    public function vote(){
        return $this->hasMany('App\Vote', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Comments', 'users_id');
    }

    public function messagesFrom(){
        return $this->hasMany('App\Messages', 'from_uid');
    }

    public function messageTo(){
        return $this->hasMany('App\Messages', 'to_uid');
    }

    public function notification(){
        return $this->hasMany('App\Notify', 'from_uid');
    }

    public function photos(){
        return $this->hasMany('App\Photo', 'user_id');
    }
}
