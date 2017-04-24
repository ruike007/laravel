@extends('layouts.app')

@section('content')
    @include('errors.errors')
    @include('slice.session')

    <div class="container-fluid">

        <form method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
            <input type="file" name="picture">
            <button type="submit"> 上传 </button>
        </form>

        <ul class="nav navbar-nav">
            <li><a href="{{ url('/eml/download') }}">表格导出</a></li>
        </ul>

    </div>

    <div id="fileuploader">Upload</div>
    <script>
        $(document).ready(function()
        {
            $("#fileuploader").uploadFile({
                url:"YOUR_FILE_UPLOAD_URL",
                fileName:"myfile"
            });
        });
    </script>

    <div class="ajax-upload-dragdrop" style="vertical-align: top; width: 400px;">
        <div class="ajax-file-upload" style="position: relative; overflow: hidden; cursor: default;">
            <font><font>上传</font>
            </font><form method="POST" action="upload.php" enctype="multipart/form-data" style="margin: 0px; padding: 0px;">
                {{ csrf_field() }}
                <input type="file" id="ajax-upload-id-1493041682417" name="myfile[]" accept="*" multiple="" style="position: absolute; cursor: pointer; top: 0px; width: 100%; height: 100%; left: 0px; z-index: 100; opacity: 0;">
            </form>
        </div>
        <span><b><font><font>拖放文件</font></font></b></span>
    </div>
@stop