<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use App\Article;
use App\Husers;
use App\Comments;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //
    public function index(Request $request){
        //dd(Session::all());

        switch($request->orderBy){
            case 'time':
                $articles = $request->category_id ? Article::where('article_category_id', $request->category_id)->where('isDraft', 0)->orderBy('created_at', 'desc')->paginate(25) : Article::where('isDraft', 0)->orderBy('created_at', 'desc')->paginate(25);
                break;
            case 'comments':
                $articles = $request->category_id ? Article::where('article_category_id', $request->category_id)->where('isDraft', 0)->orderBy('comments_total', 'desc')->paginate(25) : Article::where('isDraft', 0)->orderBy('comments_total', 'desc')->paginate(25);
                break;
            case 'votes':
                $articles = $request->category_id ? Article::where('article_category_id', $request->category_id)->where('isDraft', 0)->orderBy('votes_total', 'desc')->paginate(25) : Article::where('isDraft', 0)->orderBy('votes_total', 'desc')->paginate(25);
                break;
            case 'status':
                $articles = $request->category_id ? Article::where('article_category_id', $request->category_id)->where('article_status_id', '>=', 4)->where('isDraft', 0)->paginate(25) : Article::where('article_status_id', '>=', 4)->paginate(25);
                break;
            default:
                $articles = $request->category_id ? Article::where('article_category_id', $request->category_id)->where('isDraft', 0)->orderBy('article_status_id', 'desc')->orderBy('created_at', 'desc')->paginate(25) : Article::where('isDraft', 0)->orderBy('article_status_id', 'desc')->orderBy('created_at', 'desc')->paginate(25);
        }

        return view('index.index', ['articles' => $articles]);
    }

    public function showRegisterPage(){
        return view('index.registerPage');
    }

    public function showLoginPage(){
        return view('index.loginPage');
    }

    public function  showUserDetail(Request $request){
        $user = Husers::find($request->user_id);
        return view('user.userDetail', ['user'=>$user]);
    }


}
