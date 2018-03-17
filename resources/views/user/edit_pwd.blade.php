@extends('user.edit')

@section('form')
    <span class="iconfont icon-xiugaimima1" aria-hidden="true" style="font-size: 25px"></span><span style="font-size: 25px"> 修改密码</span>
    <hr>
    <form class="form-horizontal" method="post" action="{{ url('/users/'.$user->id.'/postPassword') }}">
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">新密码</label>
            <div class="col-sm-7">
                <input type="password" class="form-control" name="newPassword_confirmation" placeholder="new password">
            </div>
            @if($errors->has('newPassword_confirmation'))<span>密码不能为空</span>@endif
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-7">
                <input type="password" class="form-control" name="newPassword" placeholder="confirm password">
            </div>
            @if($errors->has('newPassword'))<span>确认密码不一致</span>@endif
        </div>

        <div class="form-group">
            <div class="col-sm-7 col-sm-offset-2">
                <button type="submit" class="btn btn-info">确认修改</button>
            </div>
        </div>
    </form>
@stop