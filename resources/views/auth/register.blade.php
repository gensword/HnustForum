@extends('index.index')

@section('content')
    <div class="row" style="margin-top: 100px">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div style="background-color: white; border: 1px solid #cfd1ce;">
                <form action="{{ route('register') }}" method='post'>
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="exampleInputEmail1">邮箱</label>
                        <input type="email" class="form-control" id="InputEmail" placeholder="email" name="email">
                        @if($errors->has('email'))
                            @if($errors->first('email') == 'The email has already been taken.')
                                <span style="color: #ff3a3f">邮箱已存在</span>
                            @elseif($errors->first('email') == 'The email field is required.')
                                <span style="color: #843534">请输入邮箱</span>
                            @else
                                <span style="color: #843534">请输入正确的邮箱</span>
                            @endif
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">用户名</label>
                        <input type="text" class="form-control" id="InputUsername" placeholder="username" name="username">
                        @if($errors->has('username'))
                            @if($errors->first('username') == 'The username has already been taken.')
                                <span style="color:#843534">用户名已存在</span>
                            @else
                                <span style="color: #843534">请输入用户名</span>
                            @endif
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">密码</label>
                        <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password_confirmation">
                        @if($errors->has('password_confirmation'))
                            <span style="color: #843534">请输入密码</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">确认密码</label>
                        <input type="password" class="form-control" id="ConfirmPassword" placeholder="Password" name="password">
                        @if($errors->has('password'))<span style="color: #843534">确认密码不一致</span>@endif
                    </div>
                    <div class="form-group ">
                        <label>验证码</label>
                        <input id="captcha" name="captcha">
                        <img src="{{captcha_src()}}" style= "cursor: pointer;margin-left: 20px" onclick="this.src='/captcha/default?'+Math.random()">
                        @if($errors->has('captcha'))<span style="color: #843534">验证码错误</span>@endif
                    </div>
                    <button  type="submit" class="btn btn-info  btn-block" style="margin-top: 10px">注册</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')

@endsection