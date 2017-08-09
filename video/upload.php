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
        .progress-wrap{
            background:#ccc;
            width: 200px;
            height:6px;
            border-radius:2px;
        }
        .progress{
            background:#f90;
            height: 6px;
            width:0;
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
            <div class="progress-text"></div>
            <button class="addBtn">添加...</button>
            <button class="startBtn" disabled="disabled">上傳</button>
            <button class="cancelBtn" disabled="disabled">取消</button>
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