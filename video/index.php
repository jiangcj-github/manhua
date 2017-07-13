<?php require_once("../php/global.php") ?>
<html>
<head>
    <title>視頻</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/css/page.css" rel="stylesheet">
    <style>

        .page{width:80%;margin:0 auto;padding:20px 0;}
        .page.col2{display:flex;min-width:1020px;}
        .page.col2>.left{flex-grow:1;border:1px solid #cfcfcf;}
        .page.col2>.right{margin-left:20px;width:200px;border:1px solid #cfcfcf;}

        .row{display:flex;margin:20px 0;padding:0 10px;justify-content:center;}
        .col{width:200px;height:140px;margin:0 10px;}
        .col>.col-img{width:100%;height:100%;background-size:100% 100% !important;border:1px solid #cfcfcf;}

        .page-ctrl{padding:0 20px;}
        .page-ctrl>a{
            display: inline-block;
            padding: 5px 9px;
            font-size: 12px;
            background: #fff;
            color: #666;
            border: 1px solid #e6e6e6;
        }
        .page-ctrl>a:hover{color: #3e89fa;border: 1px solid #3e89fa;}



    </style>
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page page-2col">

        <div class="row">
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
        </div>
        <div class="row">
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
        </div>
        <div class="row">
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
        </div>
        <div class="row">
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="col vpre">
                <div class="label">12:00</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
        </div>
        <div class="page-ctrl">
            <a href="#">上一页</a>
            <a href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">下一页</a>
        </div>

    </div>

</body>
</html>