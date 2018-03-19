@extends('index.index')


<style type="text/css">
    .link{color: black}
</style>

@section('content')

    <div class="row" >
        <div class="col-md-3" style="background-color:white; border: #e5e5e5 1px solid; ">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"><a href="{{ url("/users/".$user->id."/edit") }}" class="link"><span class="iconfont icon-gerenziliao2" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>wo的资料</a></li>
                <li role="presentation"><a href="{{ url("/users/".$user->id."/edit/edit_avatar") }}" class="link"><span class="iconfont icon-touxiang" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>wo的头像</a></li>
                <li role="presentation"><a href="{{ url("/users/".$user->id."/edit/edit_pwd") }}" class="link"><span class="iconfont icon-drxx25" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>wo的密码</a></li>
            </ul>
        </div>

        <div class="col-md-8 hidden-xs" style="background-color:white; border: #e5e5e5 2px solid; margin-left: 50px;padding-top: 30px">
            @section('form')
            <span class="iconfont icon-bianji" aria-hidden="true" style="font-size: 25px"></span><span style="font-size: 25px"> 编辑个人资料</span>
            <hr>
            <form class="form-horizontal" method="post" action="{{ url('/users/'.$user->id.'/postInfo') }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="username" placeholder="username" >
                        @if($errors->has('username'))<span style="color: #843534">用户名已存在</span>@endif
                    </div>
                    <span>输入新用户名</span>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">专业</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="major" placeholder="major" value={{ $user->major }}>
                    </div>
                    <span>输入专业</span>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">年级</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="grade" id="grade">
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="gender" id ="gender">
                            <option value="man">男</option>
                            <option value="female">女</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">微信</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="weixin" placeholder="weixin" value={{ $user->weixin }}>
                    </div>
                    <span>输入微信账号</span>
                </div>
                <div class="form-group">
                    <label  class="col-sm-2 control-label">个人简介</label>
                    <div class="col-sm-7">
                        <textarea class="form-control" rows="3" style="resize: none" name="resume" ></textarea>
                    </div>
                    <span>一句话介绍自己，不要太多哦</span>
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-info">确认修改</button>
                </div>
            </form>
            @show
        </div>

        <div class="col-xs-12 visible-xs-block" style="background-color:white; border: #e5e5e5 2px solid; margin-top:30px; padding-top: 30px">
            @section('form')
                <span class="iconfont icon-bianji" aria-hidden="true" style="font-size: 25px"></span><span style="font-size: 25px"> 编辑个人资料</span>
                <hr>
                <form class="form-horizontal" method="post" action="{{ url('/users/'.$user->id.'/postInfo') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="username" placeholder="username" >
                            @if($errors->has('username'))<span style="color: #843534">用户名已存在</span>@endif
                        </div>
                        <span>输入新用户名</span>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">专业</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="major" placeholder="major" value={{ $user->major }}>
                        </div>
                        <span>输入专业</span>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">年级</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="grade" id="grade">
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">性别</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="gender" id ="gender">
                                <option value="man">男</option>
                                <option value="female">女</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">微信</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="weixin" placeholder="weixin" value={{ $user->weixin }}>
                        </div>
                        <span>输入微信账号</span>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-2 control-label">个人简介</label>
                        <div class="col-sm-7">
                            <textarea class="form-control" rows="3" style="resize: none" name="resume" ></textarea>
                        </div>
                        <span>一句话介绍自己，不要太多哦</span>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-info">确认修改</button>
                    </div>
                </form>
            @show
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function(){
            $("textarea").val("{{ $user->resume }}");
            $("#grade ").val("{{ $user->grade }}");
            @if($user->gender)
            $("#gender ").val("woman");
            @else  $("#gender ").val("man");
            @endif
        })
    </script>
@endsection