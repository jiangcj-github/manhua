<?php
require_once("../../php/global.php");

/**
 *  成功返回:{ok:"ok",data:data}
 *  錯誤返回:{msg:msg_text}
 *  異常:其他
 */

session_start();
//登錄狀態
if(isset($_SESSION["login"])){
    die_json(["msg"=>"頁面已過期"]);
}
//參數檢查
if(!isset($_REQUEST["user"])||!isset($_REQUEST["pass"])){
    die_json(["msg"=>"用戶名或密碼為空"]);
}
$user=$_REQUEST["user"];
$pass=$_REQUEST["pass"];
$ip="Unknown Ip";
$country="Unknown Country";
$city="Unknown City";
if(isset($_REQUEST["ip"])){
    $ip=$_REQUEST["ip"];
}
if(isset($_REQUEST["country"])){
    $country=$_REQUEST["country"];
}
if(isset($_REQUEST["city"])){
    $city=$_REQUEST["city"];
}
//數據庫
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//登錄檢查
$stmt=$conn->prepare("select nick,time,lastLogin from user where user=? and pass=?");
$stmt->bind_param("ss",$user,$pass);
$stmt->execute();
$stmt->bind_result($nick,$time,$lastLogin);
if(!$stmt->fetch()){
    die_json(["msg"=>"用戶名或密碼不正確"]);
}
$stmt->close();
//更新lastLogin
$stmt = $conn->prepare("update user set lastLogin=? where user=? and pass=?");
$lastLogin1=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("sss",$lastLogin1,$user,$pass);
$stmt->execute();
$stmt->close();
//登錄成功
$_SESSION["login"]=["user"=>$user,"nick"=>$nick,"ip"=>$ip,"country"=>$country,"city"=>$city,"time"=>$time,"lastLogin"=>$lastLogin];
die_json(["ok"=>"ok","data"=>""]);