<html>
<head>
    <title>上傳視頻</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/css/page.css" rel="stylesheet">
    <style>
        .progress-wrap{
            background:#ccc;
            width: 200px;
            height:6px;
            border-radius:2px;
        }
        .progress{
            background:#f90;
            height: 6px;
            width:50%;
            border-radius:2px;
        }
    </style>
</head>
<body>
<!--
<?php include("../nav.php") ?>-->
<div class="page page-2col">

    <div class="sec">
        <div class="head">
            Upload Video
        </div>
        <div>
            <img class="vShow" src="web/1.png" style="width: 200px;height: 200px;">
            <div class="progress-wrap">
                <div class="progress"></div>
            </div>
            <input id="vInput" type="file" accept="video/mp4">
        </div>
        <button id="startBtn">開始</button>
        <button id="cancelBtn">取消</button>
        <input type="text" placeholder="title">
        <select>
            <option>1</option>
            <option>2</option>
        </select>


    </div>
</div>
<script src="/common/jquery-3.2.1.js"></script>
<script src="/common/fileupload/jquery.ui.widget.js"></script>
<script src="/common/fileupload/jquery.iframe-transport.js"></script>
<script src="/common/fileupload/jquery.fileupload.js"></script>

<script>

    var upload={};
    upload.vShow=$(".vShow");
    upload.vInput=$("#vInput");
    upload.vProgress="";
    upload.startBtn=null;
    upload.cancelBtn=null;
    upload.task=null;
    upload.uploadUrl="http://lindakai.com/upload/index.php";
    upload.init=function(){
        var _this=this;
        _this.vInput.fileupload({
            maxChunkSize: 2000000, // 2MB
            dataType: "json",
            url:_this.uploadUrl,
            add: function (e, data) {
                var file=data.files[0];
                if(file.type!="video/mp4"){

                }
                if(file.)

                _this.task=data.submit();
                _this.task.success(function(file){
                    var name=file.name;
                    console.log(file);
                });
            },
            progressall: function (e,data) {
                var progress = parseInt(data.loaded/data.total * 100, 10);

                console.log(progress);
            }
        });
        _this.vShow.click(function(){_this.showFileChooser();});
    };
    upload.cancel=function(data){
        this.task && this.task.abort();
    };
    upload.remove=function(data){
        var _this=this;
        this.cancel();
        $.ajax({
            url: _this.uploadUrl,
            dataType:"json",
            data: {file:data.files[0].name}
            type:"DELETE"
        });
    };
    upload.resume=function(data){
        $.getJSON("http://lindakai.com/upload/index.php",{file: data.files[0].name}, function (result) {
            var file = result.file;
            data.uploadedBytes = file && file.size;
            $.blueimp.fileupload.prototype
                .options.add.call(that, e, data);
        });
    };


    upload.showFileChooser=function(){
        this.vInput.click();
    };
    upload.upload=function(){
        var _this=this;



    };


    $(function(){
       upload.init();
    });

</script>
</body>
</html>