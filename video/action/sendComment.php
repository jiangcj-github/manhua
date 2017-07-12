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
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["text"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
$text=$_REQUEST["text"];
$time=(new DateTime())->format("Y-m-d H:i:s");
if(preg_match("/^\s*$/",$text)>0){
    die_json(["msg"=>"文本為空"]);
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//時間間隔檢查
$stmt=$conn->prepare("select comment from user_strict_v where nick=?");
$stmt->bind_param("s",$nick);
$stmt->execute();
$stmt->bind_result($stri_sec);
if( $stmt->fetch()&& $stri_sec){
    $cur_sec=(new DateTime())->getTimestamp();
    $stri_sec=DateTime::createFromFormat("Y-m-d H:i:s",$stri_sec)->getTimestamp();
    if($cur_sec-$stri_sec<300){
        die_json(["msg"=>"操作太頻繁了，需等待".(300-$cur_sec+$stri_sec)."秒"]);
    }
}
$stmt->close();
//獲取樓層
$stmt=$conn->prepare("select count(id) as count from video_comment where vid=?");
$stmt->bind_param("i",$vid);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$count++;
//插入評論
$stmt=$conn->prepare("insert into video_comment(vid,nick,text,count,time) values(?,?,?,?,?)");
$stmt->bind_param("issis",$vid,$nick,$text,$count,$time);
$stmt->execute();
$cid=$stmt->insert_id;
$stmt->close();
//記錄操作時間
$stmt=$conn->prepare("insert into user_strict_v(nick,comment) values(?,?) ON DUPLICATE KEY update comment=?");
$stri_time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("sss",$nick,$stri_time,$stri_time);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>["id"=>$cid,"nick"=>$nick,"count"=>$count,"time"=>$time]]);
