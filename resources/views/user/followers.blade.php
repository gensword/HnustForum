@extends('user.userDetail')

@section('contents')
    <div class="col-md-8 ">
        @if(Auth::id() == $user->id) <div class="row "> <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: center"><h5>hello <strong>{{ Auth::user()->username }}</strong>，这是你所有关注的人</h5></div></div>@endif
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12" style="background-color:white; border: #e5e5e5 1px solid; text-align: left; min-height: 200px">
                <h5><strong>关注的人</strong></h5>
                <hr>
                @if(count($members))
                    @foreach($members as $member)
                        <h5><a href="{{url('/users/'.$member->id)}}"><div class="col-md-1"><img src="{{ asset('image/man.jpg') }}" alt="..." class="img-circle img-responsive" ></div><span style="position: relative; top: 5px">{{ $member->username }}</span></a></h5>
                        <hr>
                    @endforeach
                @else
                    <span style="color: #909090">暂时没有内容</span>
                @endif
            </div>
        </div>
    </div>

@stop