<?php
//獲取資源服务器token
//$ip=$_SERVER["REMOTE_ADDR"];
$ip="127.0.0.1";
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
        .content{display:flex;font-size:16px;}
        .content .preview{width:200px;height:200px;border:1px solid #222;border-radius:5px;background:#ccc;}
        .content .right{flex-grow:1;margin-left:20px;padding:10px 0;}
        .content .right .btnGroup{}

        .content .right .fileShow{margin:10px 0;}
        .content .right .fileShow .fName{}
        .content .right .fileShow .fSize{font-size:14px;color: #666;}
        .content .right .pg-wrap{background:#ccc;height:14px;border-radius:3px;}
        .content .right .pg-wrap .pg{background:linear-gradient(to bottom,#f90,#c60);height:14px;border-radius:3px;width:50%;}
        .content .right .pg-info{margin:10px 0;}
        .content .right .pg-info .per{  }
        .content .right .pg-info .speed{  }
        .content .right .pg-info .spare{ }
    </style>
</head>
<body>

<?php include("../nav.php") ?>
<div class="page page-2col">

    <div class="sec">
        <div class="head">
            Upload Video
        </div>
        <div class="content">
            <img class="preview">
            <div class="right">
                <div class="btnGroup">
                    <button class="addBtn btn btn2">添加...</button>
                </div>
                <div class="fileShow">
                    <div class="fName">test.mp4</div>
                    <div class="fSize">200M</div>
                </div>
                <div class="pg-wrap">
                    <div class="pg"></div>
                </div>
                <div class="pg-info">
                    <span class="per">20%</span><span>&nbsp;</span>
                    <span class="speed">3 M/s</span>&nbsp;-&nbsp;<span class="finish">30 M</span>
                    <span>&nbsp;剩餘時間&nbsp;</span><span class="spare">30:34</span>
                </div>
                <div class="btnGroup">
                    <button class="startBtn btn btn2" disabled="disabled">上傳</button>
                    <button class="cancelBtn btn btn2" disabled="disabled">取消</button>
                </div>
            </div>
            <input id="vInput" type="file" accept="video/mp4" style="display:none;">
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
<script src="web/js/upload.js"></script>
<script>
    var _token="<?php echo $_token; ?>";
    var _time=<?php echo $time; ?>;
</script>
</body>
</html>