@extends('user.userDetail')

@section('contents')
    <div class="col-md-8 ">
        @if(Auth::id() == $user->id) <div class="row "> <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: center"><h5>hello <strong>{{ Auth::user()->username }}</strong>，这是你所有点赞过的文章</h5></div></div>@endif
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: left; min-height: 200px">
                <h5><strong>最近点赞的文章</strong></h5>
                <hr>
                @if(count($user->vote))
                    @foreach($user->vote->sortByDesc('created_at')->all() as $vote)
                        <h5><a href="{{url('/articles/'.$vote->article->id)}}">{{ $vote->article->title }}</a>&emsp;&emsp;<small>{{ $vote->article->votes_total }}点赞</small>&nbsp;&nbsp;<small>{{ $vote->article->comments_total }}回复</small><small>&nbsp;&nbsp;{{ $vote->article->created_at }}</small></h5>
                        <hr>
                    @endforeach
                @else
                    <span style="color: #909090">暂时没有内容</span>
                @endif
            </div>
        </div>
    </div>

@stop