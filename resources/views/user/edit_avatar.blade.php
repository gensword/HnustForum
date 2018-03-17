@extends('user.edit')


@section('form')
    <span class="iconfont icon-tupian" aria-hidden="true" style="font-size: 25px"></span><span style="font-size: 25px"> 请选择图片</span>
    <hr>

    <div id="image">
        <img src="{{ $user->avatar }}"  class="img-responsive"/>
    </div>

    <form action="{{ url('/users/'.$user->id.'/postAvatar') }}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="exampleInputFile">美美的头不要太大哦</label>
            <input type="file" id="File" name="avatar">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 20px" name="postAvatar">确认上传</button>
        @if(count($errors) > 0)
           <div class="alert alert-danger" role="alert" style="margin-top: 20px">{{ $errors->first('avatar') }}</div>
        @endif
        @if(Session::has('wrong'))
            @if(Session::get('wrong'))
                <div class="alert alert-danger" role="alert" style="margin-top: 20px">上传失败，请重试</div>
            @else
                <div class="alert alert-success" role="alert" style="margin-top: 20px">操作成功</div>
            @endif
        @endif
    </form>
@stop

