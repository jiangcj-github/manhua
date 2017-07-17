<?php
require_once("../php/global.php");

//是否登錄
session_start();
if(!isset($_SESSION["login"])){
    die_json(["msg"=>"用戶未登錄"]);
}
$nick=$_SESSION["login"]["nick"];
//參數檢查
if(!isset($_REQUEST["vid"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢video
$stmt=$conn->prepare("select a.filename,b.domain from video as a join units as b on a.unit=b.id where a.id = ?");
$stmt->bind_param("i",$vid);
$stmt->execute();
$stmt->bind_result($filename,$domain);
if(!$stmt->fetch()){
    die("404");
}
$stmt->close();
//下載文件
$url=generateResourceUrl($filename,$domain);
if(!fopen($url,"r")){
    die("404");
}
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".basename($url));
header("Content-Transfer-Encoding: binary");
header("Expires: 0");
header("Pragma: public");
header("Content-Length: ".filesize($url));
readfile($url);