@extends('user.userDetail')

@section('contents')
    <div class="col-md-8 ">
        @if(Auth::id() == $user->id) <div class="row "> <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: center"><h5>hello <strong>{{ Auth::user()->username }}</strong>，这是你所有发布过的文章</h5></div></div>@endif
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: left; min-height: 200px">
                <h5><strong>最近发布的文章</strong></h5>
                <hr>
                @if(count($user->articles))
                    @foreach($user->articles->sortByDesc('created_at')->all() as $article)
                        <h5><a href="{{url('/articles/'.$article->id)}}">{{ $article->title }}</a>&emsp;&emsp;<small>{{ $article->votes_total }}点赞</small>&nbsp;&nbsp;<small>{{ $article->comments_total }}回复</small><small>&nbsp;&nbsp;{{ $article->created_at }}</small></h5>
                        <hr>
                    @endforeach
                @else
                    <span style="color: #909090">暂时没有内容</span>
                @endif
            </div>
        </div>
    </div>

@stop