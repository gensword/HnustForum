@extends('index.index')

@section('content')

    <div class="row" style="margin-top: 180px">
        <div class="col-sm-12">
            <!-- Photopile Demo Gallery Markup -->
            <div class="photopile-wrapper">
                <ul class="photopile">
                    @foreach($photos as $photo)
                    <li>
                        <a href="{{ $photo->url }}">
                            <img src="{{ $photo->url }}" alt="{{ $photo->user->username }}" width="150"  />
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <a href="{{ url('/users/'.'uploadImg/'.Request::route('gender')) }}"><span class="iconfont icon-shangchuantupian"  style=" position: fixed;z-index: 100;bottom: 0px;right:0px;font-size: 50px;"></span> </a>
@stop

@section('script')
    <script src="http://www.niuqiqi.com/z-s/js/jquery-1.11.1.min.js"></script>
    <script src="{{ asset('js/jQueryUI-v1.10.4.js') }}"></script>
    <script src="{{ asset('js/photopile.js') }}"></script>
@endsection