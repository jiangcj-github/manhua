<?php
require_once("../../php/config.php");

//是否登錄
session_start();
if(!isset($_SESSION["nick"])){
    die();
}
$nick=$_SESSION["nick"];
//參數檢查
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["text"])){
    die();
}
$vid=$_REQUEST["vid"];
$text=$_REQUEST["text"];
$time=(new DateTime())->format("Y-m-d H:i:s");
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if($conn->connect_error){
    die("連接失敗");
}
$conn->set_charset("utf8");
//插入評論
$stmt=$conn->prepare("insert into video_comment(vid,nick,text,time) values(?,?,?,?)");
if($stmt){
    $stmt->bind_param("isss",$vid,$nick,$text,$time);
    $stmt->execute();
    $stmt->close();
}
$conn->close();