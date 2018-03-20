<style type="text/css">
    li{ list-style: none;}

</style>

@extends('user.userDetail')

@section('contents')
    <div class="col-md-8">
        <div class="row" style="background-color:white; border: #e5e5e5 1px solid; text-align: center">
        <h3 class="page-header">{{$article->title}}</h3>
        <span class="iconfont icon-linedesign-14 read" style="font-size: 13px;">{{ $article->read_total }} </span> <span class="iconfont icon-dianzan1" id="articleVoteNums" style="font-size: 13px;">{{ $article->votes_total }} </span> <span class="iconfont icon-pinglun1 " style="font-size: 13px;">{{ $article->comments_total }}</span>
        <hr>
        <div class="article-content" style="padding: 20px" id="show_article">
            <textarea style="display: none">{{$article->content}}</textarea>
        </div>
        </div>
        <div class="row" style="margin-top: 30px;background-color: white;border: #e5e5e5 1px solid; text-align: center;padding-top: 20px;padding-bottom: 20px">
            <div class="vote_button">
            <button class="btn btn-default vote" style="background-color: #ff7e87"><span class="iconfont icon-dianzan"></span>点赞</button>
            </div>
            @foreach($vote_users as $vote_user)
            <div class="col-md-1 col-xs-3" id= "voteUserId{{ $vote_user->user->id }}" style="text-align: center; margin-top: 10px">
                <a href="{{ url('/users/'.$vote_user->user->id) }}"><img src="{{ $vote_user->user->avatar }}" alt="..." class="img-circle img-responsive" > </a>
            </div>
                @endforeach
        </div>
        <div class="row" style="margin-top: 30px;background-color: white; border: #e5e5e5 1px solid; padding-top: 20px;padding-bottom: 20px">
            <span style="float: left" id="commentTotal">&emsp;评论数量:{{ $article->comments_total }}</span>
            <hr>
            <div class="row" style="">
                <ul id="commentList">
                    @foreach($article->comments->where('pid', 0)->all() as $comment)
                    <li>
                        <div class="comment">
                            <div class="headImage" style="width:50px;float: left"><a href="{{ url('/users/'.$comment->user->id) }}"><img src="{{ $comment->user->avatar }}" alt="..." class="img-circle img-responsive" ></a></div>
                        <span style="font-size: 14px">&emsp;{{ $comment->user->username }}</span><span style="float:right; cursor: pointer; margin-right: 20px" class="iconfont icon-iconfonthuifu"></span><span style="float:right; margin-right:10px; cursor: pointer;" class="comment_vote iconfont icon-dianzan"><span style="font-size: 10px">{{ $comment->votes_total }}</span></span>
                            <div class="commentDetail" id="commentDetail{{$comment->id}}"><span style="font-size: 12px; color: #a8a8a8" id="{{ $loop->index + 1 }}">&emsp;#{{ $loop->index + 1 }}&emsp;</span> <span style="font-size: 12px; color: #a8a8a8">@if(floor((time()-strtotime($comment->created_at))/60) < 60)
                                    {{floor((time()-strtotime($comment->created_at))/60)}}分钟前
                                @elseif(floor((time()-strtotime($comment->created_at))/60/60) < 24)
                                    {{floor((time()-strtotime($comment->created_at))/60/60)}}小时前
                                @elseif(floor(time()-strtotime($comment->created_at)/60/60/24 >= 1 ))
                                    {{floor((time()-strtotime($comment->created_at))/60/60/24)}}天前
                                @endif</span></div>
                        <div class="commentContent" style="margin-left: 60px;width:650px">{{ $comment->content }}</div>
                        <hr style="margin-top: 10px">
                        </div>
                        <ul>
                            @foreach($article->comments->where('pid', $comment->id)->all() as $childComment)
                            <li>
                                <div class="childern-comment" style="margin-left: 20px">
                                    <div class="headImage" style="width:50px;float: left"><a href="{{ url('/users/'.$childComment->user->id) }}"><img src="{{ $childComment->user->avatar }}" alt="..." class="img-circle img-responsive" ></a></div>
                                    <span style="font-size: 14px">&emsp;{{ $childComment->user->username }}</span><span style="float:right; margin-right:10px; cursor: pointer;" class="comment_vote iconfont icon-dianzan"><span style="font-size: 10px;margin-right: 10px">{{ $childComment->votes_total }}</span></span>
                                    <div class="commentDetail" id="commentDetail{{$childComment->id}}"><span style="font-size: 12px; color: #a8a8a8"> &emsp;@if(floor((time()-strtotime($childComment->created_at))/60) < 60)
                                                {{floor((time()-strtotime($childComment->created_at))/60)}}分钟前
                                            @elseif(floor((time()-strtotime($childComment->created_at))/60/60) < 24)
                                                {{floor((time()-strtotime($childComment->created_at))/60/60)}}小时前
                                            @elseif(floor(time()-strtotime($childComment->created_at)/60/60/24 >= 1 ))
                                                {{floor((time()-strtotime($childComment->created_at))/60/60/24)}}天前
                                            @endif</span></div>
                                    <div class="commentContent" style="margin-left: 60px;width:600px">{{ $childComment->content }}</div>
                                    <hr style="margin-top: 10px">
                                </div>
                            </li>
                                @endforeach
                        </ul>
                    </li>
                        @endforeach
                </ul>

            </div>
        </div>
        <div class="alert alert-success row" role="alert" style="margin-top: 30px">上善若水，厚德载物。赠人玫瑰，手留余香。请勿发布传播负能量！<br>
            评论支持 markdown 语法，详细 markdown 语法见这里 <a href="https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md">markdown 语法</a><br>
            评论支持 emoji 短标签，emoji 列表见这里 <a href="https://github.com/caiyongji/emoji-list">emoji 列表</a>
        </div>
        <div class="row" style="margin-top: 30px"><textarea id= "reply" name="reply" class="form-control" rows="4" style="resize: vertical;min-height: 120px; overflow:hidden" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'"></textarea></div>
        <div class="row" style="margin-top: 30px"><button class="btn btn-info" id="comment">回复</button></div>
        <div class=" row alert alert-warning" style= "margin-top: 15px" id="preview" role="alert">...</div>
    </div>


@stop

@section('info')
    <div class="row" style="background-color:white; border: #e5e5e5 1px solid; margin-top: 30px;text-align: center; padding-top: 10px">
        <div class="col-md-12">
            {{ $user->username }}的其他文章<hr style="margin-top: 10px">
            <ul  style="">
                @foreach($user->articles as $item)
                <li><a href="{{ url('/articles/'.$item->id) }}">{{ $item->title }}</a></li>
                    @endforeach
            </ul>
        </div>
    </div>

    <div class="row" style="background-color:white; border: #e5e5e5 1px solid; margin-top: 30px;margin-bottom:30px; text-align: center; padding-top: 10px;padding-bottom: 10px">
        <span class="iconfont icon-sixin"></span><a href="{{ url("/users/message/to/".$user->id) }}">对本社区有建议？快来私信我</a>
    </div>
@stop



@section('script')
    <script src="{{asset('editorMd/editormd.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('editorMd/lib/marked.min.js')}}"></script>
    <script src="{{asset('editorMd/lib/prettify.min.js')}}"></script>
    <script src="{{asset('editorMd/lib/raphael.min.js')}}"></script>
    <script src="{{asset('editorMd/lib/underscore.min.js')}}"></script>
    <script src="{{asset('editorMd/lib/sequence-diagram.min.js')}}"></script>
    <script src="{{asset('editorMd/lib/flowchart.min.js')}}"></script>
    <script src="{{asset('editorMd/lib/jquery.flowchart.min.js')}}"></script>

    <script>
        $(function() {
            var testEditormdView;
            testEditormdView = editormd.markdownToHTML("show_article", {
                htmlDecode      : "style,script,iframe",  // you can filter tags decode
                emoji           : true,
                taskList        : true,
                tex             : true,  // 默认不解析
                flowChart       : true,  // 默认不解析
                sequenceDiagram : true,  // 默认不解析
            });
        });


        $('document').ready(function(){
            var comments = $('.commentContent');
            for(var i=0; i<comments.length; i++){
                comments[i].innerHTML = marked(comments[i].innerHTML);
            }
            $.get("{{ url('/article/readIncrement') }}", {article_id : '{{ $article->id }}'});
        });
        $('.vote').click(function(){
            $.post("{{ url('/article/votesCount') }}", {
                article_id : '{{ $article->id }}'}, function (data) {
                if(data.isLogin == 0)
                    window.location.href="{{ url('/auth/login') }}";
                if(data.status){
                var vote = "<div class='col-md-1 col-xs-3' id=voteUserId" +data.user_id + " style='text-align: center; margin-top: 10px'>" +
                    "<a href="+"{{ url('/users/') }}"+"/"+data.user_id+"><img src="+ data.avatar +" alt='...' class='img-circle img-responsive' > </a>" +
                    "</div>";
                $('.vote_button').after(vote);
                }
                else{
                    $('#voteUserId'+ data.user_id).remove();
                }
                $('#articleVoteNums').html(data.articleVotesTotal);
            }, 'json');
        });
        function setCaretPosition(tObj, sPos){
            if(tObj.setSelectionRange){
                setTimeout(function(){
                    tObj.setSelectionRange(sPos, sPos);
                    tObj.focus();
                }, 0);
            }else if(tObj.createTextRange){
                var rng = tObj.createTextRange();
                rng.move('character', sPos);
                rng.select();
            }
        }
        $('body').on('click', '.icon-iconfonthuifu',function () {

            var replyFloor = $(this).parent().children(".commentDetail").children(":first").html();
            $('#reply').val((replyFloor.replace(/(^\s*)|(\s*$)/g, "")));
            $("html,body").animate({scrollTop:$("#reply").offset().top}, 500);
            var tObj =$("#reply");
            var sPos = tObj.val().length;
            setCaretPosition(tObj, sPos);

        });

        $('body').on('click', '.comment_vote', function(){
            var comment_id = $(this).next().attr('id');
            var votes_total = $(this).children('span');
            $.post("{{ url('/article/commentVote') }}", {id : comment_id}, function(data){
                if(data === 'isLoginFalse')
                    window.location.href="{{ url('/auth/login') }}";
                votes_total.text(data);
            });
        });

        $("#reply").on("keyup blur",function () {
            $('#preview').html(marked($("#reply").val().replace(/^#\d+/, '')))
        });

        $("#comment").click(function(){
            var replyContent = $('#reply').val().replace(/(^\s*)|(\s*$)/g, "");
            if(!replyContent){
                $('#reply').after('<div class="alert alert-danger alert-dismissable " role="alert">\n' +
                    '    <button class="close" type="button" data-dismiss="alert">×</button>\n' +
                    '    回复不能为空！\n' +
                    '</div>');
                return;
            }
            $.post("{{ url('/article/'.$article->id.'/postComments') }}", {reply:replyContent}, function(data){
                if(data.isLogin == 0)
                    window.location.href="{{ url('/auth/login') }}";
                if(data.floor){
                    var commentNode = '<li>'+
                    '<div class="childern-comment" style="margin-left: 20px">'+
                        '<div class="headImage" style="width:50px;float: left">'+
                        "<a href="+"{{ url('/users/') }}"+"/"+data.id+'><img src='+ data.avatar +' alt="..." class="img-circle img-responsive" ></a></div>'+
                    '<span style="font-size: 14px">&emsp;'+data.name+'</span>'+
                        '<span style="float:right; margin-right:10px; cursor: pointer;" class="comment_vote iconfont icon-dianzan"><span style="font-size: 10px;margin-right: 10px">0</span></span>'+
                    '<div class="commentDetail" id="commentDetail'+data.comment_id+'><span style="font-size: 12px; color: #a8a8a8"> &emsp;'+ data.time +'</span></div>'+
                    '<div class="commentContent" style="margin-left: 60px;width:600px">'+ marked(data.content) +'</div>'+
                        '<hr style="margin-top: 10px">'+
                        '</div>'+
                        '</li>';

                    $('#'+data.floor).parent('.commentDetail').parent('.comment').parent('li').children('ul').append(commentNode);
                }
                else{
                    if(parseInt($('#commentList').children('li:last').children('.comment').children('.commentDetail').children('span:first').attr('id')))
                        var id = parseInt($('#commentList').children('li:last').children('.comment').children('.commentDetail').children('span:first').attr('id')) + 1;
                    else
                        var id = 1;
                    var commentNode = '<li>'+
                    '<div class="comment">'+
                        '<div class="headImage" style="width:50px;float: left">'+
                        "<a href="+"{{ url('/users/') }}"+"/"+data.id+'><img src='+ data.avatar +' alt="..." class="img-circle img-responsive" ></a></div>'+
                    '<span style="font-size: 14px">&emsp;'+ data.name +'</span><span style="float:right; cursor: pointer; margin-right: 20px" class="iconfont icon-iconfonthuifu"></span><span style="float:right; margin-right:10px; cursor: pointer;" class="comment_vote iconfont icon-dianzan"><span style="font-size: 10px">0</span></span>'+
                    "<div class='commentDetail' id= commentDetail"+data.comment_id+"><span style='font-size: 12px; color: #a8a8a8' id="+ id +">&emsp;#"+ id +"&emsp;</span> <span style='font-size: 12px; color: #a8a8a8'>"+ data.time+
                            '</span></div>' +
                        '<div class="commentContent" style="margin-left: 60px;width:650px">'+ marked(data.content)+'</div>' +
                        '<hr style="margin-top: 10px">' +
                        '</div>' +
                        '<ul>';
                    $("#commentList").append(commentNode);
                }
                $('#commentTotal').html('&emsp;评论数量:'+data.comments_total);
                $('.icon-pinglun1').html(data.comments_total);
                $('#reply').val('');
            }, 'json');
        });


    </script>
@endsection
