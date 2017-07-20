<?php require_once("../php/global.php") ?>
<html>
<head>
    <title>視頻</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/css/page.css" rel="stylesheet">
    <style>

        .vpre:before{display:none;}

        .page{width:80%;margin:0 auto;padding:20px 0;}
        .page.col2{display:flex;min-width:1020px;}
        .page.col2>.left{flex-grow:1;border:1px solid #cfcfcf;}
        .page.col2>.right{margin-left:20px;width:200px;border:1px solid #cfcfcf;}

        .sec{padding:0 10px !important;}
        .sec .head{height:30px;line-height:30px;font-size:18px;padding:0 5px;margin:0 10px -10px 10px;
            font-family:Arial,Helvetica,sans-serif;border-radius:5px;color:#f90;}
        .sec .row{display:flex;margin:20px 0;justify-content:center;}
        .sec .row .col{width:200px;margin:0 3px;padding:7px;background:#333;border-radius:5px;}
        .sec .row .col:hover{background:#222;cursor:pointer;}
        .sec .col .vpre{height:130px;}
        .sec .col .vpre .col-img{width:100%;height:100%;background-size:100% 100% !important;}
        .sec .col .info{}
        .sec .info>.title{line-height:20px;font-weight:bold;}
        .sec .info>.more{height:20px;line-height:20px;display:flex;font-size:12px;color:#ccc;}
        .sec .info>.more .time{flex-grow:1;}
        .sec .info>.more .count{margin-right:5px;}
        .sec .info>.more .count>span{margin-left:2px;}
        .sec .info>.more .like{display:inline-flex;align-items:center;color:#f90;}
        .sec .info>.more .like img{width:14px;height:14px;margin-right:4px;}



        .page-ctrl{padding:6px 20px;text-align: right;background: #333;margin: 0 13px;}
        .page-ctrl>a{
            display: inline-block;
            padding: 6px 14px;
            font-size: 12px;
            background: linear-gradient(to bottom,#ddd,#999);
            color: #222;
            border-radius:3px;
            font-weight:bold;
        }
        .page-ctrl>a:hover{background: linear-gradient(to bottom,#999,#ddd);}
        .page-ctrl>a[disabled]{background: linear-gradient(to bottom,#999,#bbb);}



    </style>
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page page-2col">

        <div class="sec">
            <div class="head">
                Most Related Videos
            </div>
            <div class="row">
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標第三題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221<span>views</span></div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標第三方私服反三俗反三俗放鬆分題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標第三方私服反三俗反三俗放鬆分題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標第三方私服反三俗反三俗放鬆分題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="vpre">
                        <div class="label">12:00</div>
                        <div class="col-img" style="background: url(web/1.png);"></div>
                    </div>
                    <div class="info">
                        <div class="title">隨便一個標題淡淡的</div>
                        <div class="more">
                            <div class="time">2個月前</div>
                            <div class="count">12221</div>
                            <div class="like"><img src="web/img/like_solid_f90.svg">70%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-ctrl">
                <a href="#">上一頁</a>
                <a href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">下一頁</a>
            </div>
        </div>



    </div>

</body>
</html>