<?php
require_once("../../php/global.php");

/**
 *  成功返回:{ok:"ok",data:data}
 *  錯誤返回:{msg:msg_text}
 *  異常:其他
 */

//是否登錄
session_start();
if(!isset($_SESSION["login"])){
    die_json(["msg"=>"用戶未登錄"]);
}
$nick=$_SESSION["login"]["nick"];
//參數檢查
if(!isset($_REQUEST["title"])||!isset($_REQUEST["filename"])||!isset($_REQUEST["categery"])
    ||!isset($_REQUEST["unit"])||!isset($_REQUEST["duration"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$title=$_REQUEST["title"];
$filename=$_REQUEST["filename"];
$categery=$_REQUEST["categery"];
$unit=$_REQUEST["unit"];
$duration=$_REQUEST["duration"];
$time=(new DateTime())->format("Y-m-d H:i:s");
if(preg_match("/^\s*$/",$title)>0){
    die_json(["msg"=>"標題為空"]);
}
if(preg_match("/^\s*$/",$categery)>0){
    die_json(["msg"=>"分類為空"]);
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//檢測重複
$stmt=$conn->prepare("select id from video where title=? and filename=?");
$stmt->bind_param("ss",$title,$filename);
$stmt->execute();
$data=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
if(count($data)>0){
    die_json(["msg"=>"重複視頻"]);
}
//插入記錄
$stmt=$conn->prepare("insert into video(filename,duration,title,time,categery,unit) values(?,?,?,?,?,?)");
$stmt->bind_param("sssssi",$filename,$duration,$title,$time,$categery,$unit);
$stmt->execute();
$id=$stmt->insert_id;
$stmt->close();
die_json(["ok"=>"ok","data"=>["id"=>$id]]);


