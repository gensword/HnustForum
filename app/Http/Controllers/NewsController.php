<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messages;
use App\Notify;
use App\Events\SendMsg;

class NewsController extends Controller
{
    public function getNotReadMessages(Request $request){
        $nums = Messages::where('to_uid', $request->uid)
            ->where('read_status_id', 0)->count();

        echo $nums;
    }

    public function getNotReadNotifications(Request $request){
        $nums = Notify::where('to_uid', $request->uid)
            ->where('read_status_id', 0)->count();

        echo $nums;
    }

    public function sendNews($notification, $channel){
        event(new sendMsg($notification, $channel));
    }
}
