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
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["msg"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
$msg=$_REQUEST["msg"];
$time=(new DateTime())->format("Y-m-d H:i:s");
if(preg_match("/^\s*$/",$msg)>0){
    die_json(["msg"=>"文本為空"]);
}
$email="";
$describ="";
if(isset($_REQUEST["email"])){
    $email=$_REQUEST["email"];
    if(preg_grep("/^([0-9A-Za-z-_.]+)@([0-9A-Za-z-_.]+)$/",$email)<=0){
        die_json(["msg"=>"無效Email"]);
    }
}
if(isset($_REQUEST["describ"])){
    $describ=$_REQUEST["describ"];
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//時間間隔檢查
$stmt=$conn->prepare("select feedback from user_strict_v where nick=?");
$stmt->bind_param("s",$nick);
$stmt->execute();
$stmt->bind_result($stri_sec);
if( $stmt->fetch()&& $stri_sec){
    $cur_sec=(new DateTime())->getTimestamp();
    $stri_sec=DateTime::createFromFormat("Y-m-d H:i:s",$stri_sec)->getTimestamp();
    if($cur_sec-$stri_sec<600){
        die_json(["msg"=>"操作太頻繁了，需等待".(600-$cur_sec+$stri_sec)."秒"]);
    }
}
$stmt->close();
//插入反饋
$stmt=$conn->prepare("insert into video_feedback(vid,nick,msg,describ,email,time) values(?,?,?,?,?,?)");
$stmt->bind_param("isssss",$vid,$nick,$msg,$describ,$email,$time);
$stmt->execute();
$stmt->close();
//記錄操作時間
$stmt=$conn->prepare("insert into user_strict_v(nick,feedback) values(?,?) ON DUPLICATE KEY update feedback=?");
$stri_time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("sss",$nick,$stri_time,$stri_time);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>""]);
