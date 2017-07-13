<?php
require_once("../../php/global.php");

//是否登錄
session_start();
if(!isset($_SESSION["login"])){
    die_json(["msg"=>"用戶未登錄"]);
}
$nick=$_SESSION["login"]["nick"];
//參數有效性檢查
if(!isset($_REQUEST["mid"])||!isset($_REQUEST["chapter"]) ||!isset($_REQUEST["text"])){
    die_json(["msg"=>"缺少必要的參數"]);
}
$mid=$_REQUEST["mid"];
$chapter =$_REQUEST["chapter"];
$text=$_REQUEST["text"];
$time=(new DateTime())->format("Y-m-d H:i:s");
if(preg_match("/^\s*$/",$text)>0){
    die_json(["msg"=>"文本為空"]);
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//時間間隔檢查
$stmt=$conn->prepare("select comment from user_strict_mh where nick=?");
$stmt->bind_param("s",$nick);
$stmt->execute();
$stmt->bind_result($us_comment);
if( $stmt->fetch()&& $us_comment){
    $cur_sec=(new DateTime())->getTimestamp();
    $stri_sec=DateTime::createFromFormat("Y-m-d H:i:s",$us_comment)->getTimestamp();
    if($cur_sec-$stri_sec<120){
        die_json(["msg"=>"操作太頻繁了，需等待".(120-$cur_sec+$stri_sec)."秒"]);
    }
}
$stmt->close();
//插入數據
$stmt = $conn->prepare("insert into mh_comment(mid,chapter,nick,time,text) values(?,?,?,?,?)");
$stmt->bind_param("iisss",$mid,$chapter,$nick,$time,$text);
$stmt->execute();
$stmt->close();
//記錄操作時間
$stmt=$conn->prepare("insert into user_strict_mh(nick,comment) values(?,?) ON DUPLICATE KEY update comment=?");
$us_time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("sss",$nick,$us_time,$us_time);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>["mid"=>$mid,"chapter"=>$chapter,"nick"=>$nick,"time"=>$time,"text"=>$text]]);
