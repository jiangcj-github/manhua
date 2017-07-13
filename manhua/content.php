<?php require_once("../php/global.php") ?>
<!DOCTYPE html>
<html>
<head>
    <title>content</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/css/content.css" rel="stylesheet">
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page col2">
        <div class="left">
            <div class="sec m-div">
                <!--<img class="lazy" data-original="<?php echo generateResourceUrl("/1.png") ?>">-->
                <div>
                    <img class="lazy" data-original="http://n.1whour.com/newkuku/2014/201412/1205b/%E4%B8%80%E6%8B%B3%E8%B6%85%E4%BA%BA/33-40/33004.jpg">
                    <img class="lazy" data-original="http://n.1whour.com/newkuku/2014/201412/1205b/%E4%B8%80%E6%8B%B3%E8%B6%85%E4%BA%BA/33-40/33005.jpg">
                </div>

                <div class="ct-page">
                    <button class="btn" href="chapter.html">目录</button>
                    <button class="btn" href="javascript:void(0);" >上一话</button>
                    <button class="btn" href="2.html">下一话</button>
                </div>
            </div>

            <div class="sec sm-div">
                <h3>我要评论</h3>
                <textarea id="text" placeholder="不登录也可以发表评论，快来试试吧！"></textarea>
                <button class="btn btn-block" id="cm-send">提交</button>
            </div>

            <div class="sec cm-div">
                <h3>全部评论</h3>
                <ul class="cm" id="cm">
                    <script id="tpl-li" type="text/html">
                        <li class="cm-ci">
                            <div class="ci-user">{{ user }}<span style="float:right">{{ date }}</span></div>
                            <div class="ci-body">{{ content }}</div>
                        </li>
                    </script>
                </ul>
                <button class="btn btn-block" id="cm-load">加载更多</button>
            </div>

        </div>
        <div class="right">
            <div class="pane">fsf</div>
            <div class="pane">fsf</div>
            <div class="pane">fsf</div>
            <div class="pane">fsf</div>
        </div>
    </div>

    <script src="/common/jquery-3.2.1.js"></script>
    <script src="/common/jquery.lazyload.min.js"></script>
    <script src="/common/template-web.js"></script>
    <script src="web/js/page.js"></script>
    <script>
        var mid=1000,chapter=1;
    </script>
</body>
</html>