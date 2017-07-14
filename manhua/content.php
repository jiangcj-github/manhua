<?php
require_once("../php/global.php");

if(!isset($_REQUEST["mid"])||!isset($_REQUEST["chapter"])){
    die("404");
}
$mid=$_REQUEST["mid"];
$chapter=$_REQUEST["chapter"];
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢mh
$stmt=$conn->prepare("select b.domain,c.pageNum from mh as a join units as b on a.unit=b.id join mh_chapter as c on a.id=c.mid where a.id = ? and c.chapter=?");
$stmt->bind_param("id",$mid,$chapter);
$stmt->execute();
$stmt->bind_result($domain,$pageNum);
if(!$stmt->fetch()){
    die("404");
}
$stmt->close();
//bfChapter
$stmt=$conn->prepare("select chapter from mh_chapter where mid=? and chapter<? order by chapter desc limit 1");
$stmt->bind_param("id",$mid,$chapter);
$stmt->execute();
$stmt->bind_result($bfChapter);
$stmt->fetch();
$stmt->close();
//afChapter
$stmt=$conn->prepare("select chapter from mh_chapter where mid=? and chapter>? order by chapter asc limit 1");
$stmt->bind_param("id",$mid,$chapter);
$stmt->execute();
$stmt->bind_result($afChapter);
$stmt->fetch();
$stmt->close();
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
                    <a class="btn" href="cplist.php?mid=<?php echo $mid ?>">目錄</a>
                    <?php
                    if(isset($bfChapter)){
                        echo "<a class=\"btn\" href=\"content.php?mid=".$mid."&chapter=".$bfChapter."\">上一章</a>";
                    }else{
                        echo "<a class=\"btn\" href=\"javascript:void(0);\" disabled=\"disabled\">首章</a>";
                    }
                    if(isset($afChapter)){
                        echo "<a class=\"btn\" href=\"content.php?mid=".$mid."&chapter=".$afChapter."\">下一章</a>";
                    }else{
                        echo "<a class=\"btn\" href=\"javascript:void(0);\" disabled=\"disabled\">尾章</a>";
                    }
                    ?>
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