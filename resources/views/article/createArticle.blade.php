@extends('index.index')

@section('content')
    @if(count($errors) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable " role="alert">
                <button class="close" type="button" data-dismiss="alert">×</button>
                操作失败，请填写标题和内容
            </div>
        </div>
    </div>
    @endif
    @if( Session::get('success'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable " role="alert">
                    <button class="close" type="button" data-dismiss="alert">×</button>
                    操作成功！
                </div>
            </div>
        </div>
    @endif
    <form action="{{ url('/article/post/'.Request::route('category_id')) }}" method="post">
        {!! csrf_field() !!}
    <div class="row category">
        <div class="col-md-12">
            <input class="form-control" id="disabledInput" type="text" placeholder="{{ $category }}" disabled>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <input type="text" class="form-control" name="articleTitle" placeholder="请输入标题" value="{{ old('articleTitle') }}">
        </div>
    </div>
        <div class="alert alert-success col-md-12" role="alert" style="margin-top: 30px">支持 markdown 语法和拖拽图片至编辑器上传</div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div id="myeditormd" class="dropzone">
                <textarea style="display:none;" name="articleContent" >{{ old('articleContent') }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
        <button type="submit" value="publish" class="btn btn-default" name="subject">发布</button>
        </div>


    </div>
    </form>
@stop

@section('script')
    <script src="{{asset('editorMd/editormd.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script>
    var testEditor;
    $(function () {
    testEditor = editormd("myeditormd",{
    width:"100%",
    height:600,
    syncScrolling:"single",
    taskList : true,
    tocm: true,
    emoji: true,
    path:"{{asset('/editormd/lib/')}}" + "/",
    tex:true,
    flowChart       : true,
    sequenceDiagram:true,
    saveHTMLToTextarea : true,
    imageUploadURL: "php/upload.php",
    });
    });
    Dropzone.autoDiscover = false;
    $(function(){
        $(".dropzone").dropzone ({
            url:"{{ url('/article/postImg') }}",
            maxFilesize: 5,
            init:function(){
                this.on('drop', function(file){
                    var start = testEditor.getCursor();
                    testEditor.insertValue("![](upload...)");
                    var end = testEditor.getCursor();
                    testEditor.setSelection(start, end);
                });
                this.on('success', function(file, result){
                    if(result.status){
                        var imgUri = "![]" + "(" + result.imgUri + ")";
                        testEditor.replaceSelection(imgUri);
                        testEditor.setCursor({line:testEditor.getCursor().line, ch:testEditor.getCursor().ch + 1});
                    }
                    else{
                        testEditor.replaceSelection("");
                        $('.category').before('<div class="alert alert-danger alert-dismissable " role="alert">\n' +
                            '    <button class="close" type="button" data-dismiss="alert">×</button>\n' +
                            '    上传失败，请重试\n' +
                            '</div>');
                    }

                });
            }
        });
    })

    </script>
@stop