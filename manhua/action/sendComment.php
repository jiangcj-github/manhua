<?php
require_once("../../php/global.php");

session_start();
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
//
check1($conn,$nick);

//時間間隔檢查
function check1($conn, $nick){
    $stmt=$conn->prepare("select comment from user_strict_mh where nick=?");
    $stmt->bind_param("s",$nick);
    $stmt->execute();
    $comment=null;
    $stmt->bind_result($comment);
    if( $stmt->fetch()&& $comment){
        $cur_sec=(new DateTime())->getTimestamp();
        $stri_sec=DateTime::createFromFormat("Y-m-d H:i:s",$comment)->getTimestamp();
        if($cur_sec-$stri_sec<60){
            die_json(["msg"=>"操作太頻繁了，需等待".(60-$cur_sec+$stri_sec)."秒"]);
        }
    }
    $stmt->close();
}
$stmt = $conn->prepare("insert into mh_comment(mid,chapter,nick,time,text) values(?,?,?,?,?)");
$stmt->bind_param("iisss",$mid,$chapter,$nick,$time,$text);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>["mid"=>$mid,"chapter"=>$chapter,"nick"=>$nick,"time"=>$time,"text"=>$text]]);
