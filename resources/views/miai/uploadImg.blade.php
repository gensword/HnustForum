@extends('index.index')



@section('content')
    <div class="row" style="margin-top: 80px">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="row">
    <form action="{{ url('/users/'.Auth::id().'/postImages/'.Request::route('gender')) }}" class="dropzone">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>
            </div>

            <div class="row">
                <div class="alert alert-success col-md-12" role="alert" style="margin-top: 30px">请上传小于 2M 的@if(Request::route('gender') == 'man')男@else女@endif嘉宾照片，照片将会展示在@if(Request::route('gender') == 'man')男@else女@endif嘉宾栏目</div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
@endsection