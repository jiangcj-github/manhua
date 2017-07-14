<?php
require_once("../php/global.php");

$mid=1;
$chapter=1;
$domain="ddd";
$pageNum=4;
?>
<!DOCTYPE html>
<html>
<head>
    <title>content</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/css/content.css" rel="stylesheet">
    <base target="_blank">
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page col2">
        <div class="left">
            <div class="sec m-div">
                <div id="mh"></div>
                <div id="mh_buffer" data-total="<?php echo $pageNum ?>">
                    <?php
                    for($i=1;$i<=$pageNum;$i++){
                        //echo "<img p=\"".$i."\" data-src=\"".generateResourceUrl($i.".png",$domain)."\">";
                        echo "<img p=\"".$i."\" data-src=\"web/".$i.".jpg\">";
                    }
                    ?>
                </div>
                <div class="ct-page">
                    <a class="btn" href="chapter.html">目錄</a>
                    <a class="btn" href="javascript:void(0);" >上一章</a>
                    <a class="btn" href="javascript:void(0);">下一章</a>
                    <select>
                        <?php
                        for($i=1;$i<=$pageNum;$i++){
                            echo "<option value=\"".$i."\">第".$i."頁</option>";
                        }
                        ?>
                    </select>
                    <button class="btn" id="bfBtn">上一頁</button>
                    <button class="btn" id="afBtn">下一頁</button>
                </div>
            </div>

            <div class="sec sm-div">
                <h3>我要評論</h3>
                <textarea id="text" placeholder="說點什麼吧"></textarea>
                <button class="btn btn-lg" id="cm-send">提交</button>
            </div>

            <div class="sec cm-div">
                <h3>全部評論</h3>
                <ul class="cm" id="cm"></ul>
                <button class="btn btn-lg" id="cm-load" style="margin-top:10px;">加載更多</button>
            </div>

        </div>
        <div class="right">
            <div class="pane">fsf</div>
            <div class="pane">fsf</div>
            <div class="pane">fsf</div>
            <div class="pane">fsf</div>
        </div>
    </div>
    <script id="tpl-li" type="text/html">
        <li class="cm-ci">
            <div class="ci_l"><img src="/common/headimg/rand_{{comm.nick.charCodeAt(0)%20}}.png"></div>
            <div class="ci_r">
                <div class="ci-user">{{ comm.nick }}<span style="float:right">{{ comm.time }}</span></div>
                <div class="ci-body">{{ comm.text }}</div>
            </div>
        </li>
    </script>
    <script src="/common/template-web.js"></script>
    <script src="web/js/page.js"></script>
    <script>var mid=<?php echo $mid ?>,chapter=<?php echo $chapter ?>;</script>
</body>
</html>