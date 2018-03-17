@extends('user.messages')

@section('message')
    <div class="col-md-8"  style="background-color:white; border: #e5e5e5 1px solid;min-height: 250px;margin-left: 50px">
        <div class="row" style="margin-left: 15px; margin-top: 25px;"><h5 ><a href="{{ url('/users/'.Auth::id().'/messages') }}"><span class="iconfont icon-fanhui1" style="font-size: 15px"></span>返回</a></h5></div>
        <div class="row" style="margin-left: 15px">发送私信给 {{ $otherSideUser->username }}</div>
        <div class="row" style="margin-left: 0px;">
            <div class="col-md-8">
                    <textarea class="form-control msg" rows="3" style="resize: vertical; overflow-y:visible; min-height: 100px"></textarea>
            </div>
            <div class="col-md-4">
                <ul>
                    <li>支持 <a href="https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md">markdown 语法</a></li>
                    <li>支持 <a href="https://github.com/caiyongji/emoji-list">emoji 短标签</a></li>
                </ul>
            </div>
        </div>
        <button type="button" class="sendMsg btn btn-info" style="margin-top: 15px;margin-left: 15px"><span class="iconfont icon-fasong"></span>发送</button>
        <hr class="contentBehind">
        @foreach($messages as $message)
        <div class="row" style="margin-left: 15px">
            <div class="col-md-1"><a href="{{ url('/users/'.$message->from_uid) }}"><img src="{{ $message->fromUser->avatar }}" alt="..." class="img-circle img-responsive" > </a></div>
            <div class="col-md-6"><p>
                    @if( \App\Husers::find($message->from_uid)->id == Auth::id() )
                        我
                    @else
                        {{ \App\Husers::find($message->from_uid)->username }}
                    @endif
                    于  {{ $message->created_at }} ：<br><span class="talk">{{ $message->content }}</span></p></div>
        </div>
        <hr>
            @endforeach
    </div>
    @stop

@section('script')
    <script>
        $(function () {
            $.post("{{ url('/getNotReadMessages') }}", {uid:'{{ Auth::id() }}'}, function (data) {
                if(data != '0')
                    $('.privateMsg').text(data);
            })
        })
        
        $('.sendMsg').on('click', function () {
            var toUid = parseInt('{{ $otherSideUser->id }}');
            var content = $('.msg').val();
            $.post("{{ url('/sendMessages') }}", {toUid:toUid, contents:content}, function(data){
                console.log(data.content);
                console.log(data.avatar);
                var node = '<div class="row" style="margin-left: 15px">'+
                '<div class="col-md-1"><a href="{{ url('/users/'.Auth::id()) }}"><img src='+ data.avatar + ' alt="..." class="img-circle img-responsive" > </a></div>'+
                '<div class="col-md-6"><p>'+'我'+' 于'+ data.time+'：'+'<br>'+marked(data.content)+
                '</p></div>'+
                '</div>'+
                '<hr>';
                    $('.contentBehind').after(node);
                    $('.msg').val('');
            }, 'json');
        })

        $(function(){
            var talks = $('.talk');
            for(var i=0; i<talks.length; i++){
                talks[i].innerHTML = marked(talks[i].innerHTML);
            }
        });

    </script>
@stop

