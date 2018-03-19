@extends('user.messages')

@section('message')
    <div class="col-md-8 hidden-xs"  style="background-color:white; border: #e5e5e5 1px solid;min-height: 250px;margin-left: 50px">
        <div class="row" style="margin-left: 15px; margin-top: 25px;"><h5 ><a href="{{ url('/users/'.Auth::id().'/messages') }}"><span class="iconfont icon-fanhui1" style="font-size: 15px"></span>返回</a></h5></div>
        <div class="row" style="margin-left: 15px">发送私信给 {{ $user->username }}</div>
        <form method="post" action="{{ url('/sendMessages/') }}">
            {!! csrf_field() !!}
        <div class="row" style="margin-left: 0px;">
            <div class="col-md-8">
                <textarea class="form-control" rows="3" style="resize: vertical; overflow-y:visible; min-height: 100px" name="contents"></textarea>
            </div>
            <div class="col-md-4">
                <ul>
                    <li>支持 <a href="https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md">markdown 语法</a></li>
                    <li>支持 <a href="https://github.com/caiyongji/emoji-list">emoji 短标签</a></li>
                </ul>
            </div>
        </div>
            <input type="hidden" name="toUid" value="{{ $user->id }}">
        <button type="submit" class="btn btn-info" style="margin-top: 15px;margin-left: 15px"><span class="iconfont icon-fasong"></span>发送</button>
        </form>
    </div>

    <div class="col-xs-12 visible-xs-block"  style="background-color:white; border: #e5e5e5 1px solid;min-height: 250px;">
        <div class="row" style="margin-left: 15px; margin-top: 25px;"><h5 ><a href="{{ url('/users/'.Auth::id().'/messages') }}"><span class="iconfont icon-fanhui1" style="font-size: 15px"></span>返回</a></h5></div>
        <div class="row" style="margin-left: 15px">发送私信给 {{ $user->username }}</div>
        <form method="post" action="{{ url('/sendMessages/') }}">
            {!! csrf_field() !!}
            <div class="row" style="margin-left: 0px;">
                <div class="col-md-8">
                    <textarea class="form-control" rows="3" style="resize: vertical; overflow-y:visible; min-height: 100px" name="contents"></textarea>
                </div>
                <div class="col-md-4">
                    <ul>
                        <li>支持 <a href="https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md">markdown 语法</a></li>
                        <li>支持 <a href="https://github.com/caiyongji/emoji-list">emoji 短标签</a></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="toUid" value="{{ $user->id }}">
            <button type="submit" class="btn btn-info" style="margin-top: 15px;margin-left: 15px"><span class="iconfont icon-fasong"></span>发送</button>
        </form>
    </div>

@stop