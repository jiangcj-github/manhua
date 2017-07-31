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
    <title>搜索結果</title>
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
        <div class="ad1">
            400*560
        </div>
        <div id="sech-insert" style="display:none;"></div>
        <div class="ad2">
            <div style="width:300px">300*250</div>
            <div style="width:300px">300*250</div>
            <div style="width:200px">200*250</div>
            <div style="width:250px">230*250</div>
        </div>
    </div>
</div>
<script id="sech-tpl" type="text/html">
    <% for(i=0;i<data.length;i++){ %>
    <% if(i<9&&i%3==0){ %><div class="row"><% } %>
        <% if(i>=9&&(i-9)%5==0){ %><div class="row"><% } %>
            <div class="col">
                <div class="vpre">
                    <div class="label">{{data[i].duration}}</div>
                    <img src="{{data[i].poster}}" class="col-img" />
                </div>
                <div class="info">
                    <div class="title">{{data[i].title}}</div>
                    <div class="more">
                        <div class="time">{{data[i].time_str}}</div>
                        <div class="count">{{data[i].playNum}}<span>views</span></div>
                        <div class="like"><img src="web/img/like_solid_f90.svg">{{mt.round(100*data[i].up/(data[i].up+data[i].down))}}%</div>
                    </div>
                </div>
            </div>
            <% if(i<9&&i%3==2){ %></div><% } %>
        <% if(i>=9&&(i-9)%5==4){ %></div><% } %>
    <% } %>
    <% if(i<9&&i%3<2){ %></div><% } %>
    <% if(i>=9&&(i-9)%5<4){ %></div><% } %>
</script>
<script id="pg-tpl" type="text/html">
    <div class="page-ctrl">
        <% if(curPage<=1){ %>
        <a href="javascript:void(0);" class="disabled">上一頁</a>
        <% }else{ %>
        <a href="javascript:void(0);" onclick="vl.page({{curPage-1}})">上一頁</a>
        <% } %>
        <% for(var i=0;i<5;i++){ %>
        <% if(curPage<=3){ %>
        <% if(i+1>totalPage) continue; %>
        <% if(i+1==curPage){ %>
        <a href="javascript:void(0);" class="active">{{i+1}}</a>
        <% }else{ %>
        <a href="javascript:void(0);" onclick="vl.page({{i+1}})">{{i+1}}</a>
        <% } %>
        <% }else if(curPage>=totalPage-2){ %>
        <% if(totalPage-4+i<1) continue; %>
        <% if(totalPage-4+i==curPage){ %>
        <a href="javascript:void(0);" class="active">{{totalPage-4+i}}</a>
        <% }else{ %>
        <a href="javascript:void(0);" onclick="vl.page({{totalPage-4+i}})">{{totalPage-4+i}}</a>
        <% } %>
        <% }else{ %>
        <% if(curPage-2+i==curPage){ %>
        <a href="javascript:void(0);" class="active">{{curPage-2+i}}</a>
        <% }else{ %>
        <a href="javascript:void(0);" onclick="vl.page({{curPage-2+i}})">{{curPage-2+i}}</a>
        <% } %>
        <% } %>
        <% } %>
        <% if(curPage>=totalPage){ %>
        <a href="javascript:void(0);" class="disabled">下一頁</a>
        <% }else{ %>
        <a href="javascript:void(0);" onclick="vl.page({{curPage+1}})">下一頁</a>
        <% } %>
    </div>
</script>
<script>var sechkey="<?php echo $key ?>";</script>
<script src="/common/template-web.js"></script>
<script src="web/js/search.js"></script>
</body>
</html>