<?php
//獲取資源服务器token
$ip=$_SERVER["REMOTE_ADDR"];
$secret="lindakai";
$time=(new DateTime())->getTimestamp();
$_token=md5($ip.$time.$secret);
?>
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
            <input id="vInput" type="file" name="vInput" accept="video/mp4">
        </div>
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
<script src="/common/common.js"></script>

<script>
    /*
    var upload={};
    upload.vShow=$(".vShow");
    upload.vInput=$("#vInput");
    upload.vProgress="";
    upload.init=function(){
      var _this=this;
      _this.vInput.change(function(){_this.upload();});
      _this.vShow.click(function(){_this.showFileChooser();});
    };
    upload.showFileChooser=function(){
        this.vInput.click();
    };
    upload.upload=function(){
        var _this=this;
        /*
        var formData = new FormData();
        formData.append("file", $(this)[0].files[0]);
        $.ajax({
            url: "/admin/video/update/uploadPoster",
            type: "POST",
            data: formData,
            contentType:false,
            processData:false,
            xhr:function(){
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener("progress",function(e){
                        if (e.lengthComputable) {
                            var per = e.loaded/e.total*100;
                            $(".poster .progress-bar").css("width",per+"%");
                        }
                    },false);
                }
                return myXhr;
            },
            success: function(data){
                if(data.msg){
                    $("#upload_error").show();
                    $("#upload_error").children("span").text("文件"+$("#poster")[0].files[0].name+"上传失败，"+data.msg);
                }else{
                    $(".poster img").prop("src",data.url);
                }
            }
        });

        var formData = new FormData();
        formData.append("file", $(_this.vInput)[0].files[0]);
        $(_this.vInput).fileupload({
            type:"post",
            url:"upload/upload.php",
            dataType: "json",
            data: formData,
            contentType:false,
            processData:false,
            add: function (e, data) {
                console.log(data);
                data.submit();
            },
            progressall: function(e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                console.log(progress);
            },
            done: function (e, data) {
                console.log(e);
                console.log(data);
            }
        });

    };*/


    $(function(){
       //upload.init();
    });

    var _token="<?php echo $_token; ?>";
    var _time=<?php echo $time; ?>;
    var task;
    $('#vInput').fileupload({
        maxChunkSize: 2000000, // 5 MB
        dataType: "json",
        url:"http://lindakai.com/upload/index.php?_token="+_token+"&_time="+_time,
        add: function (e, data) {
            task=data.submit();
            task.success && task.success(function(file){
                var name=file.vInput[0].name;
                ajaxForm.action(null,{
                    type:"post",
                    url:"http://lindakai.com/upload/deal.php",
                    data:{_token:_token,_time:_time,name:name},
                    success:function(data){
                        if(data.ok){
                            $(".vShow").prop("src",data.data.png);
                        }
                    }
                });
            });
        }
    });


    function deal(){
        ajaxForm.action(null,{
            type:"post",
            url:"http://lindakai.com/upload/deal.php",
            data:{_token:"222",name:"test.mp4"},
            success:function(data){
                if(data.ok){
                    console.log(data.data.url);
                }
            }
        });
    }

    //task.abort();

</script>
</body>
</html>