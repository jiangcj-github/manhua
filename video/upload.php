<html>
<head>
    <title>上傳視頻</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/css/vpre.css" rel="stylesheet">
    <style>
        .sec{padding:20px 50px !important;}
        .sec .head{height:30px;line-height:30px;font-size: 18px;margin: 10px 0;font-family: Arial,Helvetica,sans-serif;color:#f90;}
        /**/
        .content{display:flex;font-size:14px;}
        .content .preview{width:200px;height:200px;border:1px solid #222;border-radius:5px;background:#666;}
        .content .right{flex-grow:1;margin-left:20px;padding:10px 0;}
        .content .right .fileShow{margin:10px 0;line-height:26px;}
        .content .right .fileShow .fName{}
        .content .right .fileShow .fSize{font-size:14px;}
        .content .right .pg-wrap{background:#ccc;height:10px;border-radius:3px;width:80%;}
        .content .right .pg-wrap .pg{background:linear-gradient(to bottom,#f90,#c60);height:10px;border-radius:3px;width:0;}
        .content .right .pg-info{margin:10px 0;}
        .content .right .pg-info .per{  }
        .content .right .pg-info .speed{  }
        .content .right .pg-info .spare{ }
        .content .right .btnGroup{}
        .content .right .btnGroup .btn{padding: 5px 15px;border-radius: 3px;}
        .content .right .btnGroup .btn[disabled]{background:gray;cursor:not-allowed;}
        /**/
        .part{margin:20px 0;line-height:30px;}
        .part label{display:block;font-size:16px;color:#f90;}
        .part label:after{content:":";}
        .part input{width:80%;height:28px;border:none !important;border-radius:3px;}
        .part select{width:300px;height:28px;border:none !important;border-radius:3px;}
        .part .btn{padding:5px 20px !important;width:100px;border-radius:3px;}
    </style>
</head>
<body>
<?php include("../nav.php") ?>
<div class="page page-2col">
    <div class="sec">
        <div class="head">
            上傳視頻
        </div>
        <?php
            if(!$isLogin){
                die("用戶未登錄");
            }
        ?>
        <div class="content">
            <img class="preview">
            <div class="right">
                <div class="btnGroup">
                    <button class="btn btn2 addBtn">添加...</button>
                    <input id="vInput" type="file" accept="video/mp4" style="display:none;">
                </div>
                <div class="fileShow">
                    <div class="fName">僅支持MP4格式，文件名不能包含除【0-9a-zA-Z_-】之外的字符。</div>
                    <div class="fSize">文件大小在【1M,200M】之間</div>
                </div>
                <div class="pg-wrap">
                    <div class="pg"></div>
                </div>
                <div class="pg-info">
                    <span class="per">0%</span><span>&nbsp;</span>
                    <span class="speed">0 M/s</span>&nbsp;-&nbsp;<span class="finish">0 M</span>
                    <span>&nbsp;剩餘時間&nbsp;</span><span class="spare">00:00</span>
                </div>
                <div class="btnGroup">
                    <button class="startBtn btn btn2" disabled="disabled">上傳</button>
                    <button class="cancelBtn btn btn2" disabled="disabled">取消</button>
                </div>
            </div>
        </div>
        <div class="part">
            <label>標題</label>
            <input type="text" id="title" placeholder="title">
        </div>
        <div class="part">
            <label>分類</label>
            <select id="categery">
                <option value="1">亞洲</option>
                <option value="2">歐美</option>
            </select>
        </div>
        <div class="part">
           <button class="btn btn2" id="submit">提交</button>
        </div>
    </div>
</div>
<script src="/common/fileupload/jquery.ui.widget.js"></script>
<script src="/common/fileupload/jquery.iframe-transport.js"></script>
<script src="/common/fileupload/jquery.fileupload.js"></script>
<?php
    require_once("../php/global.php");
    //獲取資源服务器token
    //$ip=$_SERVER["REMOTE_ADDR"];
    $ip="127.0.0.1";
    $secret="lindakai";
    $time=(new DateTime())->getTimestamp();
    $_token=md5($ip.$time.$secret);
    //獲取上傳節點
    $conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
    $conn->set_charset("utf8");
    //
    $result=$conn->query("select b.id,b.domain,b.ip from video as a join units as b on a.unit=b.id group by unit order by unit asc limit 1");
    $units=$result->fetch_all(MYSQLI_ASSOC);
    if(count($units)<=0){
        $result=$conn->query("select id,domain,ip from units where flag=1 limit 1");
        $units=$result->fetch_all(MYSQLI_ASSOC);
    }
    if(count($units)<=0){
        die("服務器錯誤");
    }
?>
<script src="web/js/upload.js"></script>
<script>
    var _token="<?php echo $_token; ?>";
    var _time=<?php echo $time; ?>;
    var uid=<?php echo $units[0]["id"]; ?>;
    var udomain="<?php echo $units[0]["domain"]; ?>";
</script>
<?php include("../footer.php") ?>
</body>
</html>