<?php
require_once("../php/config.php");

session_start();
//參數檢查
if(!isset($_REQUEST["user"])||!isset($_REQUEST["nick"])||!isset($_REQUEST["pass"])||!isset($_REQUEST["pass1"])) {
    die(json_encode(["msg"=>"參數不為空"]));
}
$user = $_REQUEST["user"];
$nick = $_REQUEST["nick"];
$pass = $_REQUEST["pass"];
$pass1 = $_REQUEST["pass1"];
if(!isset($_REQUEST["ip"])||!isset($_REQUEST["country"])||!isset($_REQUEST["city"])) {
    die(json_encode(["msg"=>"缺少必要的參數"]));
}
$ip=$_REQUEST["ip"];
$country=$_REQUEST["country"];
$city=$_REQUEST["city"];
//正則表達式檢查
if(preg_match("/^[0-9a-zA-Z_-]{5,15}$/",$user)==0){
    die(json_encode(["msg"=>"用戶名不符合規則"]));
}
if(preg_match("/^[0-9a-zA-Z_-]{8,15}$/",$pass)==0){
    die(json_encode(["msg"=>"密碼不符合規則"]));
}
if($pass!==$pass1){
    die(json_encode(["msg"=>"密碼輸入不一致"]));
}
if(preg_match("/^\S+$/",$nick)==0){
    die(json_encode(["msg"=>"會員名不符合規則"]));
}
//查數據庫
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if($conn->connect_error){
    die(json_encode(["msg"=>"連接失敗"]));
}
$conn->set_charset("utf8");
//用戶名不能重複
$stmt=$conn->prepare("select user from user where user=?");
if($stmt){
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows >= 1) {
        die(json_encode(["msg"=>"用戶名已經註冊"]));
    }
    $stmt->close();
}else{
    die(json_encode(["msg"=>"查詢失敗"]));
}
//暱稱不能重複
$stmt=$conn->prepare("select nick from user where nick=?");
if($stmt){
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows >= 1) {
        die(json_encode(["msg"=>"會員名已經註冊"]));
    }
    $stmt->close();
}else{
    die(json_encode(["msg"=>"查詢失敗"]));
}
//同一個IP只能註冊3個
$stmt=$conn->prepare("select user from user where ip=?");
if($stmt){
    $stmt->bind_param("s", $ip);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 3) {
        die(json_encode(["msg"=>"您註冊次數過多,已被限制註冊"]));
    }
    $stmt->close();
}else{
    die(json_encode(["msg"=>"查詢失敗"]));
}
//寫數據庫
$stmt=$conn->prepare("insert into user(user,nick,pass,ip,country,city,time) values(?,?,?,?,?,?,?)");
if($stmt){
    $time=(new DateTime())->format("Y-m-d H:i:s");
    $stmt->bind_param("sssssss",$user,$nick,$pass,$ip,$country,$city,$time);
    $stmt->execute();
    $stmt->close();
}else{
    die(json_encode(["msg"=>"查詢失敗"]));
}
//註冊成功
echo json_encode(["ok"=>""]);
//關閉連接
$conn->close();
