<?php
require("../../../../php/global.php");
include("../../../checkAdmin.php");

//參數檢查
if(!isset($_REQUEST["id"])){
    die_json(["msg"=>"缺少參數"]);
}
$id=$_REQUEST["id"];
if(preg_match("/^\s*$/",$id)>0){
    die_json(["msg"=>"無效參數"]);
}
//數據庫連接
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢視頻信息
$stmt=$conn->prepare("select units.domain from video join units on video.unit=units.id where video.id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($domain);
if(!$stmt->fetch()){
    die_json(["msg"=>"未發現記錄"]);
}
$stmt->close();
//刪除video_barrage
$stmt=$conn->prepare("delete from video_barrage where vid=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
//刪除video_comment
$stmt=$conn->prepare("delete from video_comment where vid=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
//刪除video_reply
$stmt=$conn->prepare("delete from video_reply where vid=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
//刪除video_feedback
$stmt=$conn->prepare("delete from video_feedback where vid=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
//刪除video
$stmt=$conn->prepare("delete from video where id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();

die_json(["ok"=>"ok","data"=>["id"=>$id,"domain"=>$domain]]);
