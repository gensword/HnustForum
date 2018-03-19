@extends('user.messages')

@section('message')
    <div class="col-md-8 hidden-xs"  style="background-color:white; border: #e5e5e5 1px solid;min-height: 250px;margin-left: 50px">
        <h4><span class="iconfont icon-xiaoxitongzhi" style="font-size: 35px"></span>我的提醒</h4><hr>
        @if(count($notifications))
            @foreach($notifications as $notification)
                <div class="row" style="margin-left: 15px">
                    <div class="col-md-1"><a href="{{ url('/users/'.$notification->from_uid) }}"><img src="{{ $notification->fromUser->avatar }}" alt="..." class="img-circle img-responsive" > </a></div>
                    <div class="col-md-8">{!! $notification->content !!}  <small>{{ $notification->created_at }}</small></div>
                </div>
                <hr>
            @endforeach
        @else
            暂时没有内容
        @endif
    </div>

    <div class="col-xs-12 visible-xs-block"  style="background-color:white; border: #e5e5e5 1px solid;min-height: 250px;">
        <h4><span class="iconfont icon-xiaoxitongzhi" style="font-size: 35px"></span>我的提醒</h4><hr>
        @if(count($notifications))
            @foreach($notifications as $notification)
                <div class="row" style="margin-left: 15px">
                    <div class="col-xs-4"><a href="{{ url('/users/'.$notification->from_uid) }}"><img src="{{ $notification->fromUser->avatar }}" alt="..." class="img-circle img-responsive" > </a></div>
                    <div class="col-xs-8">{!! $notification->content !!}  <small>{{ $notification->created_at }}</small></div>
                </div>
                <hr>
            @endforeach
        @else
            暂时没有内容
        @endif
    </div>
@stop