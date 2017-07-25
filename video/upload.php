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
            Upload Video
        </div>
        


    </div>
</div>

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
<script src="/common/template-web.js"></script>
<script src="web/js/search.js"></script>
</body>
</html>