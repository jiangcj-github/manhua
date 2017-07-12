<?php
require_once("../../php/config.php");
require_once("../../php/util.php");

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
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["cid"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
$cid=$_REQUEST["cid"];
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//時間間隔檢查
$stmt=$conn->prepare("select object from user_strict_v_cm where nick=? and cid=?");
$stmt->bind_param("si",$nick,$cid);
$stmt->execute();
$stmt->bind_result($stri_sec);
if( $stmt->fetch()&& $stri_sec){
    $cur_sec=(new DateTime())->getTimestamp();
    $stri_sec=DateTime::createFromFormat("Y-m-d H:i:s",$stri_sec)->getTimestamp();
    if($cur_sec-$stri_sec<60*60*24){
        die_json(["msg"=>"操作太頻繁了，需等待約".round((60*60*24-$cur_sec+$stri_sec)/3600)."小時"]);
    }
}
$stmt->close();
$stmt=$conn->prepare("select count(object) from user_strict_v_cm where nick=? and object>?");
$stric_p1d=(new DateTime())->sub(new DateInterval("P1D"))->format("Y-m-d H:i:s");
$stmt->bind_param("ss",$nick,$stric_p1d);
$stmt->execute();
$stmt->bind_result($stri_count);
if($stri_count>=20){
    die_json(["msg"=>"操作已達上限"]);
}
$stmt->close();
//插入踩
$stmt=$conn->prepare("update video_comment set object=object+1 where id=? and vid=?");
$stmt->bind_param("ii",$cid,$vid);
$stmt->execute();
$stmt->close();
//記錄操作時間
$stmt=$conn->prepare("insert into user_strict_v_vm(nick,cid,object) values(?,?,?) ON DUPLICATE KEY update object=?");
$stri_time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("ssss",$nick,$cid,$stri_time,$stri_time);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>""]);
