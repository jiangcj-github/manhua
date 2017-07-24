<?php
if(!isset($_REQUEST["key"])){
    die("404");
}
$key=preg_replace("/\s/","",$_REQUEST["key"]);
$key_len=mb_strlen($key);
if($key_len<=0||$key_len>20){
    die("查詢字太長或太短");
}
?>
<html>
<head>
    <title>視頻</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/css/page.css" rel="stylesheet">
    <link href="web/css/index.css" rel="stylesheet">
</head>
<body>
<?php include("../nav.php") ?>
<div class="page page-2col">

    <div class="sec">
        <div class="head">
            Most Related Videos
        </div>
        <div id="sech-insert" style="display:none;"></div>

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
<script id="sech-tpl" type="text/html">
    <% for(i=0;i<data.length;i++){ %>
        <% if(i%5==0){ %><div class="row"><% } %>
        <div class="col">
            <div class="vpre">
                <div class="label">{{data.duration}}</div>
                <div class="col-img" style="background: url(web/1.png);"></div>
            </div>
            <div class="info">
                <div class="title">{{data.title}}</div>
                <div class="more">
                    <div class="time">{{data.time}}</div>
                    <div class="count">{{data.playNum}}</div>
                    <div class="like"><img src="web/img/like_solid_f90.svg">{{Math.round(100*data.up/(data.up+data.down))}}%</div>
                </div>
            </div>
        </div>
        <% if(i%5==4){ %></div><% } %>
    <% } %>
    <% if(i%5<4){ %></div><% } %>
</script>
<script>var sechkey="<?php echo $key ?>";</script>
<script src="/common/template-web.js"></script>
<script>
    var buffer;
    ajaxForm2.action(null,{
        type:"get",
        url:"search/loadSearch.php",
        data:{key:sechkey},
        success:function(data) {
            buffer=data;
        }
    });
</script>
</body>
</html>