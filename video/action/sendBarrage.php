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
    die_json(["msg"=>"用戶為登錄"]);
}
$nick=$_SESSION["login"]["nick"];
//參數檢查
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["msg"])||!isset($_REQUEST["pos"])||!isset($_REQUEST["duration"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
$msg=$_REQUEST["msg"];
$pos=$_REQUEST["pos"];
$duration=$_REQUEST["duration"];
//參數有效性檢測
if(mb_strlen($msg)<=0||mb_strlen($msg)>15){
    die_json(["msg"=>"文本超過字符數限制"]);
}
if(preg_match("/^\s*$/",$msg)>0){
    die_json(["msg"=>"無效文本"]);
}
//[0,duration]為有效時間
if($pos<=0||$pos>=$duration){
    die_json(["msg"=>"無效時間"]);
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//時間間隔檢查
$stmt=$conn->prepare("select barrage from user_strict_v where nick=?");
$stmt->bind_param("s",$nick);
$stmt->execute();
$stmt->bind_result($stri_sec);
if( $stmt->fetch()&& $stri_sec){
    $cur_sec=(new DateTime())->getTimestamp();
    $stri_sec=DateTime::createFromFormat("Y-m-d H:i:s",$stri_sec)->getTimestamp();
    if($cur_sec-$stri_sec<60){
        die_json(["msg"=>"操作太頻繁了，需等待".(60-$cur_sec+$stri_sec)."秒"]);
    }
}
$stmt->close();
//彈幕密度控制
$speed=3;   //速度為: 1字符/s
$numRow=5;  //彈道數目
$stmt=$conn->prepare("
    delete from video_barrage 
    where id in (
        select id from (
              select id from video_barrage 
              where vid = ? and pos <= ? and ceil(pos + CHAR_LENGTH(msg) / ?) >=?
              order by CHAR_LENGTH(msg) asc
              limit 18446744073709551615 offset ?
        ) as tmp
    )
");
$maxpos=ceil($pos + mb_strlen($msg)/$speed);
$offset=$numRow-1;
$stmt->bind_param("iiiii",$vid,$maxpos,$speed,$pos,$offset);
$stmt->execute();
$stmt->close();
//插入彈幕
$stmt=$conn->prepare("insert into video_barrage(vid,nick,msg,pos) values(?,?,?,?)");
$stmt->bind_param("issi",$vid,$nick,$msg,$pos);
$stmt->execute();
$stmt->close();
//記錄操作時間
$stmt=$conn->prepare("insert into user_strict_v(nick,barrage) values(?,?) ON DUPLICATE KEY update barrage=?");
$stri_time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("sss",$nick,$stri_time,$stri_time);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>""]);