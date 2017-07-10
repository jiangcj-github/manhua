<?php
require_once("../../php/config.php");
require_once("../../php/util.php");

/**
 *  成功返回:{ok:"ok",data:data}
 *  錯誤返回:{msg:msg_text}
 *  異常:其他
 */

//登錄狀態
if(isset($_SESSION["login"])){
    die_json(["msg"=>"頁面已過期"]);
}
//參數檢查
if(!isset($_REQUEST["user"])||!isset($_REQUEST["nick"])||!isset($_REQUEST["pass"])||!isset($_REQUEST["pass1"])) {
    die_json(["msg"=>"參數不為空"]);
}
$user = $_REQUEST["user"];
$nick = $_REQUEST["nick"];
$pass = $_REQUEST["pass"];
$pass1 = $_REQUEST["pass1"];
if(!isset($_REQUEST["ip"])||!isset($_REQUEST["country"])||!isset($_REQUEST["city"])) {
    die_json(["msg"=>"缺少必要的參數"]);
}
$ip=$_REQUEST["ip"];
$country=$_REQUEST["country"];
$city=$_REQUEST["city"];
//正則表達式檢查
if(preg_match("/^[0-9a-zA-Z_-]{5,15}$/",$user)==0){
    die_json(["msg"=>"用戶名不符合規則"]);
}
if(preg_match("/^[0-9a-zA-Z_-]{8,15}$/",$pass)==0){
    die_json(["msg"=>"密碼不符合規則"]);
}
if($pass!==$pass1){
    die_json(["msg"=>"密碼輸入不一致"]);
}
if(preg_match("/^\S+$/",$nick)==0){
    die_json(["msg"=>"會員名不符合規則"]);
}
//查數據庫
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//用戶名不能重複
$stmt=$conn->prepare("select user from user where user=?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows >= 1) {
    die_json(["msg"=>"用戶名已經註冊"]);
}
$stmt->close();
//暱稱不能重複
$stmt=$conn->prepare("select nick from user where nick=?");
$stmt->bind_param("s", $nick);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows >= 1) {
    die_json(["msg"=>"會員名已經註冊"]);
}
$stmt->close();
//同一個IP只能註冊3個
$stmt=$conn->prepare("select user from user where ip=?");
$stmt->bind_param("s", $ip);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 3) {
    die_json(["msg"=>"您註冊次數過多,已被限制註冊"]);
}
$stmt->close();
//寫數據庫
$stmt=$conn->prepare("insert into user(user,nick,pass,ip,country,city,time) values(?,?,?,?,?,?,?)");
$time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("sssssss",$user,$nick,md5($pass),$ip,$country,$city,$time);
$stmt->execute();
$stmt->close();
//註冊成功
die_json(["ok"=>"ok","data"=>""]);
