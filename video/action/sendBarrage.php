<?php
require_once("../../php/config.php");

//是否登錄
session_start();
if(!isset($_SESSION["nick"])){
    die();
}
$nick=$_SESSION["nick"];
//參數檢查
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["msg"])||!isset($_REQUEST["pos"])){
    die();
}
$vid=$_REQUEST["vid"];
$msg=$_REQUEST["msg"];
$pos=$_REQUEST["pos"];
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if($conn->connect_error){
    die("連接失敗");
}
$conn->set_charset("utf8");
//彈幕密度控制
$speed=1;   //速度為: 1字符/s
$numRow=5;  //彈道數目
$stmt=$conn->prepare("
    delete from video_barrage 
    where id in (
        select id from (
              select id from video_barrage 
              where vid = ? and pos < ? and ceil(pos + CHAR_LENGTH(msg) / ?) > ?
              order by id desc
              limit 18446744073709551615 offset 5
        ) as tmp
    )
");
if($stmt){
    $stmt->bind_param("iiii",$vid,$pos,$speed,$numRow);
    $stmt->execute();
    $stmt->close();
}
//插入彈幕
$stmt=$conn->prepare("insert into video_barrage(vid,nick,msg,pos) values(?,?,?,?)");
if($stmt){
    $stmt->bind_param("issi",$vid,$nick,$msg,$pos);
    $stmt->execute();
    $stmt->close();
}
$conn->close();