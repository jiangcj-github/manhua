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
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["cid"])||!isset($_REQUEST["text"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
$cid=$_REQUEST["cid"];
$text=$_REQUEST["text"];
$time=(new DateTime())->format("Y-m-d H:i:s");
if(preg_match("/^\s*$/",$text)>0){
    die_json(["msg"=>"文本為空"]);
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//時間間隔檢查
$stmt=$conn->prepare("select reply from user_strict_v where nick=?");
$stmt->bind_param("s",$nick);
$stmt->execute();
$stmt->bind_result($stri_sec);
if( $stmt->fetch()&& $stri_sec){
    $cur_sec=(new DateTime())->getTimestamp();
    $stri_sec=DateTime::createFromFormat("Y-m-d H:i:s",$stri_sec)->getTimestamp();
    if($cur_sec-$stri_sec<120){
        die_json(["msg"=>"操作太頻繁了，需等待".(120-$cur_sec+$stri_sec)."秒"]);
    }
}
$stmt->close();
//插入評論
$stmt=$conn->prepare("insert into video_reply(vid,cid,nick,text,time) values(?,?,?,?,?)");
$stmt->bind_param("iisss",$vid,$cid,$nick,$text,$time);
$stmt->execute();
$stmt->close();
//記錄操作時間
$stmt=$conn->prepare("insert into user_strict_v(nick,reply) values(?,?) ON DUPLICATE KEY update reply=?");
$stri_time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("sss",$nick,$stri_time,$stri_time);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>""]);
