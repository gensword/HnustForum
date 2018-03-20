<?php

namespace App\Http\Controllers;

use App\Comments;
use Illuminate\Http\Request;
use App\Husers;
use App\Article;
use App\Vote;
use App\Notify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\SendMsg;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;



class ArticleController extends Controller
{
    private function saveNotification($fromUid, $toUid, $content)
    {
        $notification = New Notify;
        $notification->from_uid = $fromUid;
        $notification->to_uid = $toUid;
        $notification->content = $content;
        $notification->save();
    }

    public function showArticle($article_id)
    {
        $article = Article::find($article_id);
        $vote_users = $article->vote;
        $author = $article->user;
        return view('article.article', ['article' => $article, 'user' => $author, 'vote_users' => $vote_users]);
    }

    private function publishCommentTime($created_at)
    {
        if (floor((time() - strtotime($created_at)) / 60) < 60)
            $publishTime = floor((time() - strtotime($created_at)) / 60) . "分钟前";
        elseif (floor((time() - strtotime($created_at)) / 60 / 60) < 24)
            $publishTime = floor((time() - strtotime($created_at)) / 60 / 60) . "小时前";
        elseif (floor((time() - strtotime($created_at)) / 60 / 60 / 24) >= 1)
            $publishTime = floor((time() - strtotime($created_at)) / 60 / 60 / 24) . "天前";

        return $publishTime;
    }


    //dd($request->subject);
    public function readTotalIncrement(Request $request)
    {
        $article = Article::find($request->article_id);
        $article->read_total = $article->read_total + 1;
        $article->save();
    }

    public function postVotes(Request $request, NewsController $news, UserController $user)
    {
        if (!Auth::check()) {
            echo json_encode(array('isLogin' => 0));
            return;
        }
        $article_id = $request->article_id;
        $user_id = Auth::id();
        $article = Article::find($article_id);
        $author_id = $article->user_id;

        $avatar = Husers::find($user_id)->avatar;

        if (!Vote::where('article_id', $article_id)->where('user_id', $user_id)->count()) {
            $vote = new Vote;
            $vote->user_id = $user_id;
            $vote->article_id = $article_id;
            $vote->save();

            $article->votes_total += 1;
            $article->save();

            $user->vitalityIncrement(Auth::id(), 1); //活跃度加一

            //发送点赞通知至作者
            $message = array('content' => Auth::user()->username . ' 给 ' . "<a href=" . url('/articles/' . $article_id) . ">" . $article->title . "</a>" . ' 点了赞',
                'to_uid' => $author_id);
            $channel = 'notification';
            $news->sendNews($message, $channel);

            //存至消息表
            $notification = new Notify;
            $notification->content = $message['content'];
            $notification->to_uid = $author_id;
            $notification->from_uid = Auth::id();
            $notification->read_status_id = 0;
            $notification->save();

            $data = array('user_id' => $user_id, 'status' => 1, 'articleVotesTotal' => $article->votes_total, 'avatar' => $avatar);
        } else {
            $vote = Vote::where('article_id', $article_id)->where('user_id', $user_id)->first();
            $vote->delete();

            $article->votes_total -= 1;
            $article->save();
            $data = array('user_id' => $user_id, 'status' => 0, 'articleVotesTotal' => $article->votes_total, 'avatar' => $avatar);
        }
        echo json_encode($data);
    }

    public function postComments(Request $request, UserController $user)
    {
        if (!Auth::check()) {
            echo json_encode(array('isLogin' => 0));
            return;
        }
        $comment = new Comments;
        //dd($request->reply);
        if (preg_match('/^#(\d+)/', $request->reply, $matches)) {    //回复相应楼层
            $commentRange = intval($matches[1]) - 1;
            if ($commentRange > Comments::where('pid', 0)->count())    //如果回复楼层不存在，则该回复为顶级回复
                $comment->pid = 0;
            else
                $comment->pid = DB::table('comments')->where('pid', '=', 0)->where('article_id', '=', $request->article_id)->offset($commentRange)->limit(1)->get()->first()->id;
            $comment->content = preg_replace('/^#(\d+)/', '', $request->reply);
        } else {   //顶级回复
            $comment->pid = 0;
            $comment->content = preg_replace_callback('/:(\w+):/', function ($matches) {
                return emoji($matches[0]);     //":smile:" -> unicode字符
            }, $request->reply);
        }

        $comment->article_id = $request->article_id;
        $comment->users_id = Auth::id();
        $comment->votes_total = 0;

        $comment->save();

        $user->vitalityIncrement(Auth::id(), 1); //活跃度加1

        $article = Article::find($request->article_id);
        $article->comments_total += 1; //该文章对应评论数量加一
        $article->save();

        if ($comment->pid)
            $commentFloor = $commentRange + 1;     //回复楼层
        else
            $commentFloor = '';
        echo json_encode(array('id' => $comment->users_id,
            'name' => Auth::user()->username,
            'time' => $this->publishCommentTime(date('Y-m-d H:i:s')),
            'content' => $comment->content,
            'floor' => $commentFloor,
            'comment_id' => $comment->id,
            'comments_total' => $article->comments_total,
            'avatar' => Husers::find(Auth::id())->avatar));
    }

    public function postCommentsVote(Request $request)
    {
        //给相应评论点赞

        if (!Auth::check()) {
            echo 'isLoginFalse';
            return;
        }
        preg_match('/\d+/', $request->id, $matches);
        $comment_id = $matches[0];
        $comment = Comments::find($comment_id);
        $comment->votes_total += 1;
        $comment->save();

        echo $comment->votes_total;
    }

    public function showCreatePage(Request $request)
    {
        //展示创建文章页面

        switch ($request->category_id) {
            case 1:
                $category = '爱旅行';
                break;
            case 2:
                $category = '爱学习';
                break;
            case 3:
                $category = '爱运动';
                break;
            case 4:
                $category = '爱游戏';
                break;
            case 5:
                $category = '问答专区';
                break;
            case 6:
                $category = '跳蚤市场';
                break;
            case 10:
                $category = '无聊吐槽';
                break;
            default:
                break;
        }

        return view('article.createArticle', ['category' => $category]);
    }

    public function postArticleImg(Request $request)
    {
        //上传文章图片

        $this->validate($request, ['file' => 'bail|required|image|max:5000']);

        $disk = Storage::disk('qiniu');
        $time = date('Y/m/d-H:i:s');
        $filename = $disk->put($time, $request->file('file'));//上传
        if (!$filename) {
            return response()->json([
                'status' => 0
            ]);
        }
        $img_url = $disk->getDriver()->downloadUrl($filename); //获取下载链接
        return response()->json([
            'status' => 1,
            'imgUri' => $img_url
        ]);
    }

    public function postArticle(Request $request, NewsController $news, UserController $user)
    {
        //发布或保存草稿

        $validator = Validator::make($request->all(), [
            'articleTitle' => 'required',
            'articleContent' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        switch ($request->subject) {
            case 'publish':
                $isDraft = 0;  //发布
                break;
            case 'draft':
                $isDraft = 1;  //保存草稿
                break;
            default:
                break;
        }

        $article = new Article;
        $article->content = $request->articleContent;
        $article->title = $request->articleTitle;
        $article->article_category_id = $request->category_id;
        $article->article_status_id = 1;
        $article->votes_total = 0;
        $article->read_total = 0;
        $article->comments_total = 0;
        $article->user_id = Auth::id();
        $article->isDraft = $isDraft;
        $article->save();

        if (!$isDraft) {
            $message = array(
                'content' => '你关注的用户 ' . "<a href=" . url('/users/' . Auth::id()) . ">" . Auth::user()->username . "</a>" . ' 发布了文章  ' . "<a href=" . url('/articles/' . $article->id) . ">" . $article->title . "</a>",
            );
            $channel = 'notification';

            foreach ($user->getFans(Auth::user()) as $fans) {
                $message['to_uid'] = $fans;
                //dd($fans);
                $news->sendNews($message, $channel);
                $this->saveNotification(Auth::id(), $fans, $message['content']);
            }

            $user->vitalityIncrement(Auth::id(), 2);  //活跃度加2
        }

        return redirect()->back()
            ->withInput()
            ->with('success', 1);
    }


    public function searchArticles(Request $request)
    {
        //搜索文章

        $articles = Article::where('isDraft', 0)
            ->search($request->search, null, true, true)
            ->with('user')
            ->paginate(25);

        $users = Husers::search($request->search, null, true)->get();

        return view('article.search', ['searchArticles' => $articles, 'users' => $users]);
    }
}

