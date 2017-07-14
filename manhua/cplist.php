<?php
require_once("../php/global.php");

if(!isset($_REQUEST["mid"])){
    die("404");
}
$mid=$_REQUEST["mid"];
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢mh_chapter
$stmt=$conn->prepare("select pageNum,chapter from mh_chapter where mid=?");
$stmt->bind_param("i",$mid);
$stmt->execute();
$result=$stmt->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>content</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/css/page.css" rel="stylesheet">
    <base target="_blank">
    <style>
        .cp-div .row{display:flex;padding: 5px 0;}
        .cp-div .row a{color:#222;margin:0 5px;min-width:80px;text-align:center;line-height:28px;letter-spacing:1px;}
        .cp-div .row a.visited{background:#e4e4e4;}
    </style>
</head>
<body>
<?php include("../nav.php") ?>
<div class="page col2">
    <div class="left">


        <div class="sec cp-div">
            <h3>所有章節</h3>
            <?php
            for($i=0;$i<count($data);$i++){
                if($i%5==0){
                    echo "<div class=\"row\">";
                }
                echo "<a href=\"content.php?mid=".$mid."&chapter=".$data[$i]["chapter"]."\" class=\"btn btn1\">第".$data[$i]["chapter"]."章[".$data[$i]["pageNum"]."p]</a>";
                if($i%5==4){
                    echo "</div>";
                }
            }
            if(count($data)%5!=4){
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div class="right">
        <div class="pane">fsf</div>
        <div class="pane">fsf</div>
        <div class="pane">fsf</div>
        <div class="pane">fsf</div>
    </div>
</div>
<script>var mid=<?php echo $mid ?>;</script>
<script>
    $(".cp-div .row a").click(function(){
        $(this).addClass("visited");
    })
</script>
</body>
</html>