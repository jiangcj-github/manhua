<?php require_once("../../php/resource.php") ?>
<!DOCTYPE html>
<html>
<head>
    <title>漫画网</title>
    <meta charset="utf-8">
    <meta name="keywords" content="xxx,xxx,xxx">
    <meta name="description" content="xxxxx">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/page.css" rel="stylesheet">
</head>
<body>
<div class="content">
    <h1 style="margin-left:auto;margin-right:auto;">一拳超人 第54话</h1>
    <img class="lazy" data-original="<?php echo generateResourceUrl("/1.png") ?>">
    <div class="ct-page">
        <button class="btn" href="chapter.html">目录</button>
        <button class="btn" href="javascript:void(0);" >上一话</button>
        <button class="btn" href="2.html">下一话</button>
    </div>

    <div style="height:20px"></div>
    <h3>我要评论</h3>
    <textarea id="text" placeholder="不登录也可以发表评论，快来试试吧！"></textarea>
    <button class="btn btn-block" id="cm-send">提交</button>

    <div style="height:20px"></div>
    <h3>全部评论</h3>
    <ul class="cm" id="cm">
        <script id="tpl-li" type="text/html">
            <li class="ci">
                <div class="ci-user">{{ user }}<span style="float:right">{{ date }}</span></div>
                <div class="ci-body">{{ content }}</div>
            </li>
        </script>
    </ul>
    <button class="btn btn-block" id="cm-load">加载更多</button>

</div>

<div class="rBar">
    <div class="sec">fsf</div>
    <div class="sec">dff</div>
    <div class="sec">sf</div>
    <div class="sec">sff</div>
</div>

<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/jquery-lazyload/1.9.5/jquery.lazyload.min.js"></script>
<script src="http://pv.sohu.com/cityjson"></script>
<script src="../js/template-web.js"></script>
<script src="../js/page.js"></script>
<script>
    var mid=1000,chapter=1;
</script>
</body>
</html>