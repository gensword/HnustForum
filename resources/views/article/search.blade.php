@extends('index.index')

@section('content')
    <div style="background-color: white; border: #e5e5e5 1px solid;">
        <div class="row" style="margin-top: 20px">
            <div class="col-md-8" style=" padding-left: 30px;">
            <span class="iconfont icon-iconfontzhizuobiaozhun22" style="font-size: 15px"></span>关于 "<span style="color: red">{{Request::get('search')}}</span>" 的搜索结果，共 {{ $searchArticles->total() + count($users)}} 条
            </div>
        </div>
        <hr>
        @if($searchArticles->total() + count($users))
            @foreach($users as $user)
                <div class="row" style="">
                    <div class="col-md-1">
                        <div class="col-md-11 col-xs-4" style=" padding-right: 0px">
                            <a href="{{ url('/users/'.$user->id) }}"><img src="{{ $user->avatar }}" alt="..." class="img-circle img-responsive" > </a>
                        </div>
                    </div>
                    <div class="col-md-11" style=" ">
                        <a href="{{ url('/users/'.$user->id) }}"><h4>{{ $user->username }}</h4></a>
                        第 {{ $user->id }} 位会员 {{ $user->created_at }} &nbsp;&nbsp;{{ $user->followers }} 关注者 &nbsp;&nbsp;{{ $user->articles->count() }} 篇文章 &nbsp;&nbsp; {{ $user->comments->count() }} 条回复
                    </div>
                </div>
                <hr>
            @endforeach

            @foreach($searchArticles as $searchArticle)
        <div class="row" style="">
            <div class="col-md-1">
            <div class="col-md-11 col-xs-4" style=" padding-right: 0px">
                <a href="{{ url('/users/'.$searchArticle['user']['id']) }}"><img src="{{ $searchArticle['user']['avatar'] }}" alt="..." class="img-circle img-responsive" > </a>
            </div>
            </div>
            <div class="col-md-11" style="">
                <a href="{{ url('/articles/'.$searchArticle['id']) }}"><h4>{{ $searchArticle['title'] }}</h4></a>
                <a href="{{ url('/articles/'.$searchArticle['id']) }}">{{ url('/articles/'.$searchArticle['id']) }}</a> &emsp;<small>{{ $searchArticle['created_at'] }} &emsp;<span class="iconfont icon-linedesign-14 " style="font-size: 12px;">{{ $searchArticle['read_total'] }} </span>&nbsp;<span class="iconfont icon-dianzan1"  style="font-size: 13px;">{{ $searchArticle['votes_total'] }} </span>&nbsp;<span class="iconfont icon-pinglun1"  style="font-size: 13px;">{{ $searchArticle['comments_total'] }} </span></small>
                <br><br>{{ mb_substr($searchArticle['content'], 0, 200, 'utf-8').'...' }}
            </div>
        </div>
            <hr>
                @endforeach
            @else
            <div class="row" style="height: 100px">
                <div class="col-sm-3"></div>
                <div class="col-sm-3" style="color: #cfd1ce">暂时没有内容</div>
                <div class="col-sm-3"></div>
            </div>
        @endif
    </div>
@stop