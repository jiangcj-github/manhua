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
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["vote"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
$vote=(int)$_REQUEST["vote"];
if($vote!==0 && $vote!==1){
    die_json(["msg"=>"無效參數"]);
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//時間間隔檢查
$stmt=$conn->prepare("select vote from user_strict_v2 where nick=? and vid=?");
$stmt->bind_param("si",$nick,$vid);
$stmt->execute();
$stmt->bind_result($stri_sec);
if( $stmt->fetch()&& $stri_sec){
    $cur_sec=(new DateTime())->getTimestamp();
    $stri_sec=DateTime::createFromFormat("Y-m-d H:i:s",$stri_sec)->getTimestamp();
    if($cur_sec-$stri_sec<60*60*24){
        die_json(["msg"=>"已經投票了，需等待約".round((60*60*24-$cur_sec+$stri_sec)/3600)."小時"]);
    }
}
$stmt->close();
//上限檢查
$stmt=$conn->prepare("select count(vote) from user_strict_v2 where nick=? and vote>?");
$stric_p1d=(new DateTime())->sub(new DateInterval("P1D"))->format("Y-m-d H:i:s");
$stmt->bind_param("ss",$nick,$stric_p1d);
$stmt->execute();
$stmt->bind_result($stri_count);
$stmt->fetch();
if($stri_count>=10){
    die_json(["msg"=>"操作已達上限"]);
}
$stmt->close();
//插入投票
if($vote==1){
    $stmt=$conn->prepare("update video set up=up+1 where id=?");
}else if($vote==0){
    $stmt=$conn->prepare("update video set down=down+1 where id=?");
}
$stmt->bind_param("i",$vid);
$stmt->execute();
$stmt->close();
//記錄操作時間
$stmt=$conn->prepare("insert into user_strict_v2(nick,vid,vote) values(?,?,?) ON DUPLICATE KEY update vote=?");
$stri_time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("siss",$nick,$vid,$stri_time,$stri_time);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>""]);
