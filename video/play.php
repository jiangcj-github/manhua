<?php

require_once("../php/config.php");
require_once("../php/util.php");

if(!isset($_REQUEST["id"])){
    die("404");
}
$id=$_REQUEST["id"];
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢video
$stmt=$conn->prepare("select * from video where id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($id,$filename,$duration,$unit);
if(!$stmt->fetch()){
    die("404");
}
$stmt->close();
//查詢units
$stmt=$conn->prepare("select domain from units where id = ?");
$stmt->bind_param("i",$unit);
$stmt->execute();
$stmt->bind_result($domain);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>play</title>
    <link href="web/videojs/video-js.css" rel="stylesheet">
    <link href="web/videojs/video-js-custom.css" rel="stylesheet">
    <script src="web/videojs/video.js"></script>
</head>
<body>
    <?php include("../nav.php") ?>

    <video class="video-js" controls preload="auto" width="640" height="268" data-setup="{}" >
        <source src="<?php echo generateResourceUrl($filename,$domain) ?>" type="video/mp4">
    </video>



    <input type="hidden" id="v_id" value="<?php echo $id ?>">
    <input type="hidden" id="v_duration" value="<?php echo $duration ?>">

    <input type="text"><button id="bg-submit">提交</button>

    <textarea></textarea><button id="cm-submit">提交</button>


    <script src="web/js/page.js"></script>
</body>
</html>