<?php die("404"); ?>
<?php
require_once("../php/global.php");

if(!isset($_REQUEST["id"])){
    die("404");
}
$id=$_REQUEST["id"];
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢video
$stmt=$conn->prepare("select a.id,a.filename,b.domain,a.up,a.down,a.playNum from video as a join units as b on a.unit=b.id where a.id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($id,$filename,$domain,$up,$down,$playNum);
if(!$stmt->fetch()){
    die("404");
}
$stmt->close();
$videoUrl=generateResourceUrl($id.".mp4",$domain);
$posterUrl=generateResourceUrl($id."_p.png",$domain);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>embed</title>
    <link href="web/videojs/video-js.css" rel="stylesheet">
    <link href="web/videojs/video-js-custom.css" rel="stylesheet">
    <script src="web/videojs/video.js"></script>
    <style>
        body{margin:0;padding:0;width:100%;height:100%;}
        main{}
    </style>
</head>
<body>
    <video class="video-js" id="v1" controls preload="auto" poster="<?php echo $posterUrl; ?>"  data-setup="{}">
        <source src="<?php echo $videoUrl; ?>" type="video/mp4">
    </video>
</body>
</html>
<?php
//寫入playNum,lastPlayTime
$stmt=$conn->prepare("update video set playNum=playNum+1,lastPlayTime=? where id=?");
$lastPlayTime=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("si",$lastPlayTime,$id);
$stmt->execute();
$stmt->close();
?>
