<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ url('js/socket.io/node_modules/socket.io-client/dist/socket.io.js') }}"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

<!-- Styles -->
<link href="//at.alicdn.com/t/font_565298_bwa1t634ubceg66r.css" rel="stylesheet">
<link href="{{ asset('font/iconfont.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/photopile.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-switch.min.css') }}" rel="stylesheet"><link rel="stylesheet" href="{{asset('editorMd/css/editormd.min.css')}}">
    <style>
        .top{
            min-height: 6px; width: 100%; background-color: #6b9dbb;
        }
        .users-label{
            text-align: center;
        }
        a.users-label-item{
            border: 1px solid rgba(52, 52, 53, 0.23);
            display: inline-block;
            border-radius: 23px;
            padding: 0px 9px 0px 0px;
            margin: 3px;
            color: rgba(0, 0, 0, 0.87);
            text-decoration: none;
        }
        a.users-label-item img {
            border-radius: 50%;
            margin-right: 4px;
            width: 28px;
            height: 28px;
        }
        a{
            color: #858585;
        }

    </style>
</head>

<body style="background-color:#f0f2f5">
@section('top')
<div class="top"></div>
<nav class="navbar navbar-default ">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#example-navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/index') }}" >Hnust</a>
        </div>
        <div class="collapse navbar-collapse" id="example-navbar-collapse">
        <ul class="nav navbar-nav">
            <li >
                <a href="{{ url('/index/1') }}"> 爱旅行</a>
            </li>
            <li>
                <a href="{{ url('/index/2') }}"> 爱学习</a>
            </li>
            <li>
                <a href="{{ url('/index/3') }}"> 爱运动</a>
            </li>
            <li><a href="{{ url('/index/4') }}">爱游戏</a></li>
            <li><a href="{{ url('/index/5') }}">问答专区</a></li>
            <li><a href="{{ url('/index/10') }}">无聊吐槽</a></li>
            <li><a href="{{ url('/index/6') }}">跳蚤市场</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">非诚勿扰 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/showImages/man') }}">男嘉宾</a></li>
                    <li><a href="{{ url('/showImages/female') }}">女嘉宾</a></li>
                </ul>
            </li>
        </ul>
        <form class="navbar-form navbar-right" role="search" action="{{ url('/article/search') }}">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="search">
                <span class="input-group-btn">
        <button class="btn btn-default iconfont icon-iconfontzhizuobiaozhun22" type="submit" ></button>
      </span>
            </div>&nbsp;&nbsp;&nbsp;
            @if(!Auth::check())
            <button type="button"  class="btn btn-default" onclick="location.href='{{url("/auth/register")}}'">
                <span class="iconfont icon-zhuce2" aria-hidden="true"></span><span>注册</span></button>
            <button type="button"  class="btn btn-default"  onclick="location.href='{{url("/auth/login")}}'">
                <span class="iconfont icon-denglu1" aria-hidden="true"></span><span>登录</span></button>
            @else
                <a href="{{ url('/users/'.Auth::id().'/messages') }}" style="color: #bfbfbf" data-toggle="tooltip" data-placement="bottom" title="消息提醒" ><span class="iconfont icon-icon" aria-hidden="true"><span class="notifyNums badge"></span></span></a>&nbsp;&nbsp;&nbsp;
                <ul class="nav navbar-nav navbar-right" style="">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/users/'.Auth::id()) }}"> <span class="iconfont icon-zhuce2" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>个人中心</a></li>
                        <li><a href="{{ url('/logout') }}"><span class="iconfont icon-tuichu1" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>退出</a></li>
                    </ul>
                </li>
                </ul>
            @endif
        </form>
        </div>
    </div>
</nav>
@show
<div class="container">
    @section('content')
        <div class="row" style="margin-left: -15px">
            <div class="col-md-8" style="background-color: white; border: #e5e5e5 1px solid; padding-left: 40px">
                <div class="row" style="margin-top: 20px">
                    <span style="font-size: 15px">

                      <a href="{{ url(Request::path().'?orderBy=status') }}">精华</a>&emsp;&emsp;
                        <a href="{{ url(Request::path().'?orderBy=votes') }}">投票</a>&emsp;&emsp;
                        <a href="{{ url(Request::path().'?orderBy=time') }}">最近</a>&emsp;&emsp;
                        <a href="{{ url(Request::path().'?orderBy=comments') }}">回复</a></span>
                </div>
                <hr style="margin-top: 10px">
                @if(isset($articles) && count($articles))
                @foreach($articles as $article)
                <div class="row" >
                <div class="col-md-1 col-xs-3" style="padding-left: 0px ;">
                    <a href="{{ url('/users/'.$article->user_id) }}"><img src="{{ $article->user->avatar }}" alt="..." class="img-circle img-responsive" > </a>
                </div>
                    @if(in_array($article->article_status_id, [2]))
                    <div class="col-md-1 col-xs-1" style="margin-top: 10px;padding-left: 0px" >
                        <span class="label label-success">置顶</span>
                    </div>
                    <div class="col-md-8 col-xs-8" style="margin-top: 10px;padding-left: 0px">
                        <a href="{{url('/articles/'.$article->id)}}">{{ $article->title }}</a>
                    </div>
                     @elseif(in_array($article->article_status_id, [4, 6]))
                        <div class="col-md-1 col-xs-1" style="margin-top: 10px;padding-left: 0px" >
                            <span class="label label-success">加精</span>
                        </div>
                        <div class="col-md-8 col-xs-8" style="margin-top: 10px;padding-left: 0px">
                            <a href="{{url('/articles/'.$article->id)}}">{{ $article->title }}</a>
                        </div>
                    @else
                        <div class="col-md-9 col-xs-9" style="margin-top: 10px;padding-left: 0px">
                            <a href="{{url('/articles/'.$article->id)}}">{{ $article->title }}</a>
                        </div>
                    @endif
                    <div class="col-md-2 col-xs-8" style="margin-top: 10px;padding-left: 5px; ">{{ $article->votes_total }} /{{ $article->comments_total }}/
                        @if(floor((time()-strtotime($article->created_at))/60) < 60)
                            {{floor((time()-strtotime($article->created_at))/60)}}分钟前
                            @elseif(floor((time()-strtotime($article->created_at))/60/60) < 24)
                            {{floor((time()-strtotime($article->created_at))/60/60)}}小时前
                            @elseif(floor(time()-strtotime($article->created_at)/60/60/24 >= 1 ))
                            {{floor((time()-strtotime($article->created_at))/60/60/24)}}天前
                        @endif
                    </div>
                </div>
                <hr style="margin-top: 10px">
                @endforeach
                    <div class="row">
                        {{ $articles->links() }}
                    </div>
                @else
                    <div class="row" style="min-height: 80px; color: #bfbfbf">
                        暂时没有内容
                    </div>
                @endif
            </div>
            <div class="col-md-3 hidden-xs" style="margin-left:80px;">
                <div class="row" style="background-color:#ffffe3; border: #e5e5e5 1px solid;text-align: center">
                <h4 >社区规则</h4><hr style="margin-top: 10px">
                <p style="margin-top: 10px">魅力的双唇，在于亲切友善的语言。<br>
                    可爱的双眼，要善于看到别人的优点。<br>
                    请和谐讨论，做善良的自己
                </p></div>
                <div class="row" style="margin-top: 50px; background-color: white;border: #e5e5e5 1px solid;text-align: center">
                    <span style="">活跃用户</span><hr style="margin-top: 10px">
                    <div class="users-label">
                    @foreach(\App\Husers::all()->sortByDesc('vitality')->take(10) as $activeUser)
                    <a class="users-label-item" href="{{ url('/users/'.$activeUser->id) }}" title="louduanxiong">
                        <img class="avatar-small inline-block" src="{{ $activeUser->avatar }}"> {{ $activeUser->username }}
                    </a>
                    @endforeach
                    </div>
                </div>

            </div>

            <div class="col-xs-12 visible-xs-block" style="margin-top: 30px; ">
                <div class="row" style="background-color:#ffffe3; border: #e5e5e5 1px solid;text-align: center">
                    <h4 >社区规则</h4><hr style="margin-top: 10px">
                    <p style="margin-top: 10px">魅力的双唇，在于亲切友善的语言。<br>
                        可爱的双眼，要善于看到别人的优点。<br>
                        请和谐讨论，做善良的自己
                    </p></div>
                <div class="row" style="margin-top: 50px; background-color: white;border: #e5e5e5 1px solid;text-align: center">
                    <span style="">活跃用户</span><hr style="margin-top: 10px">
                    <div class="users-label">
                        @foreach(\App\Husers::all()->sortByDesc('vitality')->take(10) as $activeUser)
                            <a class="users-label-item" href="{{ url('/users/'.$activeUser->id) }}">
                                <img class="avatar-small inline-block" src="{{ $activeUser->avatar }}"> {{ $activeUser->username }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    @show
</div>
@if( Route::currentRouteName() == 'category')<a href="{{ url('articles/create/'.Request::route('category_id')) }}" style="color: #838383"><span class="iconfont icon-bianji2"  style=" position: fixed;z-index: 100;bottom: 70px;right:0px;font-size: 55px;cursor:pointer;"></span> </a> @endif
<a style="color: #838383"><span class="iconfont icon-fanhuidingbu" id="top" style="display:none; position: fixed;z-index: 100;bottom: 0px;right:0px;font-size: 50px;cursor:pointer;"></span> </a>
@section('footer')
    <div class="jumbotron " style=" margin-top:150px; background-color: white">
        <div class="container">
            <div class="row" style="margin-top: 0px;">
                <div class="col-md-6">
            <p style="font-size: 16px">
                建设此站的目的是为了让更多的科大学生有一个更方便的讨论交流平台<br>
                希望大家积极参与，和谐讨论
            </p>
                </div>
                <div class="col-md-2 col-md-offset-4">
                    <p style="font-size: 16px">统计信息</p>
                    <p style="font-size: 14px">社区人数:{{ count(\App\Husers::all()) }}<br>文章数:{{ count(\App\Article::all()) }}<br>评论数:{{ count(\App\Comments::all()) }}</p>

                </div>
            </div>
        </div>
    </div>
@show

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>

<script>

    $(function () {

       $(window).scroll(function(e){
            if($(window).scrollTop() > 400){ $('#top').fadeIn(1000);}
            else{$('#top').fadeOut(1000);}
       });

        $('[data-toggle="tooltip"]').tooltip();

    });

    $(function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    });

    $(function () {
        var status = '{{ Auth::check() }}';
        if( status){
        $.post("{{ url('/getNotReadMessages') }}", {uid:'{{ Auth::id() }}'}, function(data){
            $('.notifyNums').text(data);
            $.post("{{ url('/getNotReadNotifications') }}", {uid:'{{ Auth::id() }}'}, function(data){
                var notReadMsg = $('.notifyNums').text();
                var total = parseInt(notReadMsg) + parseInt(data);
                $('.notifyNums').text(total);
            });
        });
        }

    });

    $(document).ready(function(){
        document.getElementById('File').onchange = function() {

            var imgFile = this.files[0];
            var fr = new FileReader();
            fr.onload = function() {
                document.getElementById('image').getElementsByTagName('img')[0].src = fr.result;
            };
            fr.readAsDataURL(imgFile);
        };});


     $('#top').click(function(){
         $("html,body").animate({scrollTop:0}, 1000);
     })

    @section('listen')
    var status = '{{ Auth::check() }}';
    if( status){
    var socket = io('http://www.51zixuea.cn:6001');

    socket.on('pmessage{{ Auth::id() }}', function (data) {
        console.log(data);
                var notifyNums = parseInt($('.notifyNums').text()) + 1;
                $('.notifyNums').text(notifyNums);
    });

        socket.on('notification{{ Auth::id() }}', function (data) {
            console.log(data);
            var notifyNums = parseInt($('.notifyNums').text()) + 1;
            $('.notifyNums').text(notifyNums);
        });

    }
    @show()



</script>

@yield('script')

</body>

</html>