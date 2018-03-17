<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Husers;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Facades\Gate;
use App\Notify;


class UserController extends Controller
{
    private function changeUserAvatar($avatar){
        //用户修改头像

        $user = Husers::find(Auth::id());
        $user->avatar = $avatar;
        $user->save();
    }

    public function vitalityIncrement($userId, $increment){
        $user = Husers::find($userId);
        $user->vitality += $increment;
        $user->save();
    }

    public function getFans($user){
        $fans = Redis::smembers('fans:'.$user->id);
        return $fans;
    }

    public function logout(){
        Auth::logout();
        return Redirect::to('/index');
    }

    public function showEdit(Request $request){
        //展示用户编辑资料页面

        if (Gate::denies('edit_userInfo', $request)) {
            abort(403, 'sorry');
        }
        $user = Auth::user();
        return view('user.edit', ['user'=> $user]);
    }

    public function showEditPwd(Request $request){
        if (Gate::denies('edit_userInfo', $request)) {
            abort(403, 'sorry');
        }
        $user = Auth::user();
        return view('user.edit_pwd', ['user'=> $user]);
    }

    public function showEditAvatar(Request $request){
        if (Gate::denies('edit_userInfo', $request)) {
            abort(403, 'sorry');
        }
        $user = Auth::user();
        return view('user.edit_avatar', ['user'=> $user]);
    }

    public function showEditNotify(Request $request){
        if (Gate::denies('edit_userInfo', $request)) {
            abort(403, 'sorry');
        }
        $user = Auth::user();
        return view('user.edit_notify', ['user'=> $user]);
    }
/*
    public function register(Request $request, Husers $user){
           $this->validate($request, [
               'captcha' => 'bail|required|captcha',
               'password_confirmation' => 'required',
               'username' => 'bail|required|unique:husers',
               'email' => 'bail|required|email|unique:husers',
               'password' =>'required|confirmed']);

           $user->username = $request->username;
           $user->email = $request->email;
           $user->password = password_hash($request->password, PASSWORD_BCRYPT);
           $user->followers = 0;
           $user->vitality = 0;
           $user->user_status_id = 1;
           $user->notify_status_id = 7;
           $user->save();

           Session::put('username', $request->username);
           return Redirect::action('IndexController@index');
    }*/


    public function postInfo(Request $request, $user_id){

        //用户变更个人资料
        $this->validate($request, [
            'username' => 'bail|required_without_all:resume,major,grade,gender,weixin|unique:Husers',
            'major' => 'required_without_all:resume,username,grade,gender,weixin',
            'grade' => 'bail|required_without_all:resume,major,username,gender,weixin|integer',
            'gender' => 'bail|required_without_all:resume,major,grade,username,weixin|in:man,female',
            'weixin' => 'required_without_all:resume,major,grade,gender,username',
            'resume' => 'required_without_all:username,major,grade,gender,weixin'
        ]);

        $user = Husers::find($user_id);
        if($request->username)
            $user->username = $request->username;
        if($request->major)
            $user->major = $request->major;
        if($request->grade)
            $user->grade = $request->grade;
        if($request->weixin)
            $user->weixin = $request->weixin;
        if($request->resume)
            $user->resume = $request->resume;
        if($request->gender)
            if($request->gender == 'man')
                $user->gender = 0;
            else $user->gender = 1;
        $user->save();

        return Redirect::to('/users/'.$user_id);
    }

    public function postAvatar(Request $request){
        //用户变更头像

        $this->validate($request, ['avatar' => 'bail|required|image|max:2000']);

        $disk = Storage::disk('qiniu');
        $time = date('Y/m/d-H:i:s');
        $filename = $disk->put($time, $request->file('avatar'));//上传七牛云
        if(!$filename) {
            return Redirect::back()->with('wrong', 1);
        }
        $img_url = $disk->getDriver()->downloadUrl($filename); //获取下载链接
        $this->changeUserAvatar($img_url);
        return Redirect::back()->with('wrong', 0);
    }

    public function showVoteArticle(Request $request){
        //展示用户点过赞的文章

        $user = Husers::find($request->user_id);
        return view('user.voteArticle', ['user'=>$user]);
    }

    public function showPublishArticle(Request $request){
        //展示用户发布的文章

        $user = Husers::find($request->user_id);
        return view('user.publishArticle', ['user'=>$user]);
    }

    public function showFollowers(Request $request){
        //展示用户关注列表

        $user = Husers::find($request->user_id);

        $set = 'followers:'.$request->user_id;
        $membersId = Redis::smembers($set);
        $members = Husers::find($membersId);
        //dd($members);
        return view('user.followers', ['members'=>$members, 'user'=> $user]);
    }

    public function showCommentArticle(Request $request){
        //展示用户评论过的文章

        $user = Husers::find($request->user_id);
        return view('user.commentArticle', ['user'=>$user]);
    }

    public function postPassword(Request $request, $user_id){
        //用户变更密码

        $this->validate($request, [
            'newPassword_confirmation' => 'required',
            'newPassword' => 'confirmed'
        ]);

        $user = Husers::find($user_id);
        $user->password = $request->newPassword;
        $user->save();

        return Redirect::to('/users/'.$user_id);
    }



    public function showNotify(Request $request){
        //展示用户收到的消息

        if (Gate::denies('edit_userInfo', $request)) {
            abort(403, 'sorry');
        }
        Notify::where('to_uid', $request->user_id)
            ->where('read_status_id', 0)
            ->update(['read_status_id' => 1]);        //更改消息状态为已读

        $user = Husers::find($request->user_id);

        $notifications = Notify::where('to_uid', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('user.notify', ['user'=>$user, 'talks' => array(), 'notifications' => $notifications]);
    }

    public function follow(Request $request, NewsController $news){
        //关注用户

        $owner = 'followers:'.Auth::id();
        $follower = $request->followUid;

        $fans = 'fans:'.$request->followUid;
        $fancer = Auth::id();

        Redis::sadd($owner, $follower);  //向关注者列表添加关注者
        Redis::sadd($fans, $fancer);     //向被关注者粉丝列表添加粉丝

        //将被关注者数据库followers字段加一
        $user = Husers::find($request->followUid);
        $user->followers += 1;
        $user->save();

        //发送通知
        $content = Auth::user()->username.'关注了你';
        $to_uid = $follower;
        $from_uid = Auth::id();
        $read_status_id = 0;
        $notification = new Notify;
        $notification->content = $content;
        $notification->to_uid = $to_uid;
        $notification->from_uid = $from_uid;
        $notification->read_status_id = $read_status_id;
        $notification->save();

        $channel = 'notification';
        $message = array('content' => $content, 'to_uid' => $to_uid);

        $news->sendNews($message, $channel);

        return Redirect::to('/users/'.$request->followUid);
    }

    public function cancelFollow(Request $request, NewsController $news){
        //取消关注

        $owner = 'followers:'.Auth::id();
        $follower = $request->cancelUid;

        $fans = 'fans:'.$request->cancelUid;
        $fancer = Auth::id();

        Redis::srem($owner, $follower);  //向关注者列表移除关注者
        Redis::srem($fans, $fancer);     //向被关注者粉丝列表移除粉丝

        $user = Husers::find($request->cancelUid);
        $user->followers -= 1;
        $user->save();

        //发送通知
        $content = Auth::user()->username.'对你取消关注';
        $to_uid = $follower;
        $from_uid = Auth::id();
        $read_status_id = 0;
        $notification = new Notify;
        $notification->content = $content;
        $notification->to_uid = $to_uid;
        $notification->from_uid = $from_uid;
        $notification->read_status_id = $read_status_id;
        $notification->save();

        $channel = 'notification';
        $message = array('content' => $content, 'to_uid' => $to_uid);

        $news->sendNews($message, $channel);

        return Redirect::to('/users/'.$request->cancelUid);
    }

}
