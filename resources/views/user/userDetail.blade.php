@extends('index.index')
<style type="text/css">
.link{color: black}
</style>

@section('content')
  <div class="row">
      <div class="col-md-3">
          <div class="row"  style="background-color:white; border: #e5e5e5 1px solid">
          <div class="row page-header">
          <div class="col-md-6 col-xs-6">
              <a href="{{ url('/users/'.$user->id) }}"><img src="{{ $user->avatar }}" alt="..." class="img-circle img-responsive" styly=""></a>
          </div>
              <div class="col-md-6 col-xs-6" ><h4>{{ $user->username }}</h4>@if($user->gender)<span class="iconfont icon-xingbienv"></span>@else<span class="iconfont icon-xingbienan"></span>@endif<p> 第 {{$user->id}} 位会员<br>注册于 {{$user->created_at}}</p></div>
          </div>
              <div class="row" style="text-align: center">
                  @if($user->user_status_id == 2)
                    <span class="label label-success">Admin</span>&emsp;
                    @endif
                  @if($user->status_id == 3)
                    <span class="label label-success">founder</span>
                  @endif
              </div>
              <div class="row page-header" ><div class="col-md-1"></div><div class="col-md-3 col-xs-3"><h4>&nbsp;&nbsp;{{ $user->followers }}</h4>关注者</div><div class="col-md-3 col-xs-3"><h4>&nbsp;&nbsp;{{count($user->articles)}}</h4>文章</div><div class="col-md-3 col-xs-3"><h4>&nbsp; {{count($user->comments)}}</h4>评论</div></div>
              <div class="row page-header">
                  <div class="col-md-1"></div>
                  <div class="col-md-3 col-xs-3">
                        <span class="label label-Info" data-toggle="tooltip" data-placement="bottom" title="@if(!empty($user->major)){{ $user->major }}@else 暂未填写 @endif" style="cursor:pointer;">专业</span>
                  </div>
                  <div class="col-md-3 col-xs-3">
                      <span class="label label-default" data-toggle="tooltip" data-placement="bottom" title="@if(!empty($user->grade)){{ $user->grade }}@else 暂未填写 @endif" style="cursor:pointer;">年级</span>
                  </div>
                  <div class="col-md-3 col-xs-3">
                      <span class="label label-success" data-toggle="tooltip" data-placement="bottom" title="@if(!empty($user->weixin)){{ $user->weixin }}@else 暂未填写 @endif" style="cursor:pointer;">微信</span>
                  </div>
              </div>
              @section('profile')
                  @if(Auth::id() == $user->id)
          <div class="row" >
              <div class="col-md-1"></div>
              <div class="col-md-10">

                  <button type="button" class="btn btn-info btn-block" onclick="location.href='{{ url("/users/".$user->id."/edit") }}'"><span class="iconfont icon-gerenziliao1" aria-hidden="true"></span><span>个人资料</span></button>
              </div>
              <div class="col-md-1"></div></div>
                  @else
                      <div class="row" >
                          <div class="col-md-1"></div>
                          <div class="col-md-10">

                              <button type="button" class="btn btn-default btn-block" onclick="location.href='{{ url("/users/message/to/".$user->id) }}'"><span class="iconfont icon-sixin" aria-hidden="true"></span><span>私信ta</span></button>
                          </div>
                          <div class="col-md-1"></div></div>
                      <div class="row" style="margin-top: 5px">
                          <div class="col-md-1"></div>
                          <div class="col-md-10">
                                @if(!Redis::sismember('fans:'.$user->id, Auth::id()))
                                    <form action="{{ url("/users/follow/".$user->id) }}" method="post">
                                        {!! csrf_field() !!}
                                    <button type="submit" style="background-color: #ff7e87" class="btn btn-danger btn-block" ><span class="iconfont icon-attend" aria-hidden="true"></span><span>关注ta</span></button>
                                    </form>
                              @else
                                  <button type="button"  class="btn btn-default btn-block" onclick="location.href='{{ url("/users/cancelFollow/".$user->id) }}'"><span class="iconfont icon-quxiaoguanzhu1" aria-hidden="true"></span><span>取消关注</span></button>
                              @endif
                          </div>
                          <div class="col-md-1"></div></div>
                  @endif
              @show
          </div>
          @section('info')
          <div class="row" style="background-color:white; border: #e5e5e5 1px solid; margin-top: 40px">
              <div class="col-md-12">
                          <ul class="nav nav-pills nav-stacked">
                              <li role="presentation"><a href="{{ url('/users/'.$user->id.'/follow') }}" class="link"><span class="iconfont icon-guanzhuderen" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>@if($user->id == Auth::id())wo关注的用户@else ta关注的用户 @endif</a></li>
                              <li role="presentation"><a href="{{ url('/users/'.$user->id.'/vote') }}" class="link"><span class="iconfont icon-dianzan" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>@if($user->id == Auth::id())wo点赞的文章@else ta点赞的文章 @endif</a></li>
                              <li role="presentation"><a href="{{ url('/users/'.$user->id.'/publish') }}" class="link"><span class="iconfont icon-fatie" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>@if($user->id == Auth::id())wo发布的文章@else ta发布的文章 @endif</a></li>
                              <li role="presentation"><a href="{{ url('/users/'.$user->id.'/comment') }}" class="link"><span class="iconfont icon-huati00" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>@if($user->id == Auth::id())wo评论的文章@else ta评论的文章 @endif</a></li>
                          </ul>
              </div>
          </div>
            @show
      </div>
      <div class="col-md-1"></div>
      @section('contents')
      <div class="col-md-8 ">
          <div class="hidden-xs">
          @if(Auth::id() == $user->id)
          <div class="row "> <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: center"><h5>hello <strong>{{ $user->username }}</strong>，你可以在这里修改和查看你的个人相关资料</h5></div></div>
              @elseif($user->resume)
                <div class="row"> <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: center;"><h5>{{ $user->resume }}</h5></div></div>
          @endif
          </div>
          <div class="row" style="margin-top: 30px;">
              <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: left; min-height: 200px">
                  <h5><strong>最近发布的文章</strong></h5>
                  <hr>
                  @if(count($user->comments))
                  @foreach($user->articles->sortByDesc('created_at')->take(5) as $article)
                  <h5><a href="{{url('/articles/'.$article->id)}}">{{ $article->title }}</a>&emsp;&emsp;<small>{{ $article->votes_total }}点赞</small>&nbsp;&nbsp;<small>{{ $article->comments_total }}回复</small><small>&nbsp;&nbsp;{{ $article->created_at }}</small></h5>
                  <hr>
                  @endforeach
                  @else
                      <span style="color: #909090">暂时没有内容</span>
                  @endif

              </div>
          </div>

          <div class="row" style="margin-top: 30px;">
              <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: left; min-height: 200px">
                  <h5><strong>最近讨论的文章</strong></h5>
                  <hr>
                  @if(count($user->comments))
                      @foreach($user->comments->unique('article_id')->sortByDesc('created_at')->take(5) as $comment)
                      <h5><a href="{{url('/articles/'.$comment->article->id)}}">{{ $comment->article->title }}</a>&emsp;&emsp;<small>{{ $comment->article->votes_total }}点赞</small>&nbsp;&nbsp;<small>{{ $comment->article->comments_total }}回复</small><small>&nbsp;&nbsp;{{ $comment->article->created_at }}</small></h5>
                      <hr>
                      @endforeach
                  @else
                      <span style="color: #909090">暂时没有内容</span>
                  @endif
              </div>
          </div>

          <div class="row" style="margin-top: 30px;">
              <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: left; min-height: 200px">
                  <h5><strong>最近点赞的文章</strong></h5>
                  <hr>
                  @if(count($user->vote))
                      @foreach($user->vote->sortByDesc('created_at')->take(5) as $vote)
                          <h5><a href="{{url('/articles/'.$vote->article->id)}}">{{ $vote->article->title }}</a>&emsp;&emsp;<small>{{ $vote->article->votes_total }}点赞</small>&nbsp;&nbsp;<small>{{ $vote->article->comments_total }}回复</small><small>&nbsp;&nbsp;{{ $vote->article->created_at }}</small></h5>
                          <hr>
                      @endforeach
                  @else
                      <span style="color: #909090">暂时没有内容</span>
                  @endif
              </div>
          </div>
              @show
      </div>
  </div>
@stop
