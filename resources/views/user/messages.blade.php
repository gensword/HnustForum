@extends('index.index')

@section('content')
    <script src="{{asset('editorMd/lib/marked.min.js')}}"></script>
    <div class="row" >
        <div class="col-md-3" style="background-color:white; border: #e5e5e5 1px solid; text-align: center;min-height: 150px">
            <ul class="nav nav-pills nav-stacked" style="margin-top: 30px">
                <li role="presentation"><a href="{{url('/users/'.Auth::id().'/messages')}}" class="link"><span class="iconfont icon-sixin1" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>wo的私信<span class="privateMsg badge"></span></a></li>
                <li role="presentation"><a href="{{url('/users/'.Auth::id().'/notify')}}" class="link"><span class="iconfont icon-icon" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>wo的消息<span class="notification badge"></span></a></li>
            </ul>
        </div>
        @section('message')
        <div class="col-md-8"  style="background-color:white; border: #e5e5e5 1px solid;min-height: 250px;margin-left: 50px">
            <h4><span class="iconfont icon-sixin" style="font-size: 35px"></span>我的私信</h4><hr>
            @if(count($talks))
                @foreach($talks as $talk)
                <div class="row" style="margin-left: 15px">
                    <div class="col-md-1"><a href="{{ url('/users/'.\App\Husers::find($talk->from_uid)->id) }}"><img src="{{ \App\Husers::find($talk->from_uid)->avatar }}" alt="..." class="img-circle img-responsive" > </a></div>
                    <div class="col-md-4"><p>
                            @if( \App\Husers::find($talk->from_uid)->id == Auth::id() )
                                我
                            @else
                                {{ \App\Husers::find($talk->from_uid)->username }}
                            @endif
                            于  {{ $talk->created_at }} ：<br><span class="talk">{{ $talk->content }}</span><a href="{{ url('/users/'.Auth::id().'/messages/'.$talk->talk_id) }}"><span class="iconfont icon-huati"></span>@if($talk->read_status_id)查看对话 @else未读信息 @endif</a></p></div>
                </div>
                <hr>
                @endforeach
            @else
                暂时没有内容
            @endif
        </div>
            @show()
    </div>
    @stop

@section('listen')
    var status = '{{ Auth::check() }}';
    if( status){
    var socket = io('http://localhost:6001');

    socket.on('pmessage{{ Auth::id() }}', function (data) {
    console.log(data);
    var notifyNums = parseInt($('.notifyNums').text()) + 1;
    $('.notifyNums').text(notifyNums);
    if($('.privateMsg').text())
        $('.privateMsg').text(parseInt($('.privateMsg').text()) + 1);
    else
        $('.privateMsg').text('1');
    });

    socket.on('notification{{ Auth::id() }}', function (data) {
    console.log(data);
    var notifyNums = parseInt($('.notifyNums').text()) + 1;
    $('.notifyNums').text(notifyNums);
    if($('.notification').text())
    $('.notification').text(parseInt($('.notification').text()) + 1);
    else
    $('.notification').text('1');
    });

    }

@stop

@section('script')
<script>
    $(function () {
        $.post("{{ url('/getNotReadMessages') }}", {uid:'{{ Auth::id() }}'}, function (data) {
            if(data != '0')
                $('.privateMsg').text(data);
        });

        $.post("{{ url('/getNotReadNotifications') }}", {uid:'{{ Auth::id() }}'}, function (data) {
            if(data != '0')
                $('.notification').text(data);
        });
    })

    $(function(){
        var talks = $('.talk');
        for(var i=0; i<talks.length; i++){
            talks[i].innerHTML = marked(talks[i].innerHTML);
        }
    })
</script>
@stop