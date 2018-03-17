@extends('index.index')

@section('content')
    <div class="row" style="margin-top: 100px">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div style="background-color: white; border: 1px solid #cfd1ce;">
                <form  action="{{ route('login') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="InputUsername">用户名</label>
                        <input type="text" class="form-control" id="InputUsername" placeholder="username" name="username">
                        @if(count($errors) > 0)<span style="color: #843534">账号不存在或密码错误</span>@endif
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">密码</label>
                        <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password">
                    </div>
                    <div style="padding-left: 280px">
                        <span><a href="">忘记密码？</a></span></div>
                    <button type="submit" class="btn btn-info  btn-block" style="margin-top: 10px">登录</button>
                </form>
            </div>
        </div>
    </div>
@stop