<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Husers;
use App\Messages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{

    private function ajaxResponse($content){
        //返回发送信息用户和信息内容

        $fromUser = Husers::find(Auth::id());

        $response = json_encode(array('avatar' => $fromUser->avatar, 'content' => $content, time => date('Y-m-d H:i:s')));

        echo $response;
    }

    private function getOtherSideUser($message_id){
        //获取对话另一方

        $message = Messages::where('talk_id', $message_id)->first();
        $otherSideUid = $message->from_uid == Auth::id() ? $message->to_uid : $message->from_uid;
        $otherSideUser = Husers::find($otherSideUid);
        //dd($otherSideUser);
        return $otherSideUser;
    }

    public function showMessages(Request $request){
        //展示和用户有关的信息即该用户发送或接收的消息

        if (Gate::denies('edit_userInfo', $request)) {
            abort(403, 'sorry');
        }

        $talks = DB::table('Messages')
            ->where('from_uid', '=', $request->user_id)
            ->orwhere('to_uid', '=', $request->user_id)
            ->groupBy('talk_id')
            ->orderBy('created_at', 'desc')
            ->get();
        //dd($talk_ids);
        $talk_ids = array();

        foreach ($talks as $talk ){
            array_push($talk_ids, $talk->talk_id);
        }
        $talkArray = array();
        //dd($talk_ids);
        foreach($talk_ids as $talk_id){
            $message = DB::table('Messages')
                ->where('talk_id', '=', $talk_id)
                ->latest()
                ->first();
            array_push($talkArray, $message);
        }

        //dd($talkArray);
        return view('user.messages', ['talks'=> $talkArray]);
    }

    public function showTalks(Request $request){
        //展示两用户间的消息

        if (Gate::denies('edit_userInfo', $request)) {
            abort(403, 'sorry');
        }

        $messages = Messages::where('talk_id', $request->message_id)
            ->get()
            ->sortByDesc('created_at')
            ->all();
        //dd($messages);

        $otherSideUser = $this->getOtherSideUser($request->message_id);

        Messages::where('talk_id', $request->message_id)
            ->where('read_status_id', 0)
            ->update(['read_status_id' => 1]);

        return view('user.messageDetail', ['messages' => $messages, 'otherSideUser' => $otherSideUser]);
    }

    public function showMessageTo(Request $request){
        //展示发送页面

        $toUid = $request->toUid;
        $user = Husers::find($toUid);

        return view('user.messageTo', ['user' => $user]);
    }

    public function sendMessage(Request $request, NewsController $news){
        //发送消息

        $newMessage = new Messages;
        $newMessage->content = preg_replace_callback('/:(\w+):/', function ($matches) {
            return emoji($matches[0]);
        }, $request->contents);
        $newMessage->read_status_id = 0;
        $newMessage->from_uid = Auth::id();
        $newMessage->to_uid = $request->toUid;
        $newMessage->talk_id = $newMessage->from_uid > $request->toUid ? intval($request->toUid.$newMessage->from_uid) : intval($newMessage->from_uid.$request->toUid);
        $newMessage->save();

        $message = array('fromUid' => $request->fromUid,
            'to_uid' => $request->toUid,
            'time' => date('Y-m-d H:i:s'),
            'content' => $request->contents);
        if($request->ajax()){
            $channel = "pmessage";
            $news->sendNews($message, $channel);

            $this->ajaxResponse($newMessage->content);
            return ;
        }

        $channel = "pmessage";
        $news->sendNews($message, $channel);     //发送消息提醒
        return Redirect::to('/users/'.Auth::id().'/messages');
    }

}
