<?php
require_once("../../php/global.php");

/**
 *  成功返回:{ok:"ok",data:data}
 *  錯誤返回:{msg:msg_text}
 *  異常:其他
 */

//參數檢查
if(!isset($_REQUEST["email"])||!isset($_REQUEST["nick"])||!isset($_REQUEST["pass"])) {
    die_json(["msg"=>"參數不為空"]);
}
$user = $_REQUEST["email"];
$nick = $_REQUEST["nick"];
$pass = $_REQUEST["pass"];
$ip=$_SERVER["REMOTE_ADDR"];
//正則表達式檢查
if(!preg_match("/^[0-9a-zA-Z._-]+@[0-9a-zA-Z._-]+$/",$user)){
    die_json(["msg"=>"邮箱不符合规范"]);
}
if(!preg_match("/^[0-9a-zA-Z_-]{8,15}$/",$pass)){
    die_json(["msg"=>"密碼不符合規則"]);
}
//查數據庫
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//用戶名不能重複
$stmt=$conn->prepare("select user from user where user=?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result=$stmt->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
if(count($data)>0){
    die_json(["msg"=>"邮箱已被注册"]);
}
$stmt->close();
//暱稱不能重複
$stmt=$conn->prepare("select nick from user where nick=?");
$stmt->bind_param("s", $nick);
$stmt->execute();
$result=$stmt->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
if(count($data)>0){
    die_json(["msg"=>"昵称已被注册"]);
}
$stmt->close();
//同一個IP只能註冊3個
$stmt=$conn->prepare("select user from user where ip=?");
$stmt->bind_param("s", $ip);
$stmt->execute();
$result=$stmt->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
if(count($data)>3){
    die_json(["msg"=>"注册次数过多，已被限制注册"]);
}
$stmt->close();
//寫數據庫
$stmt=$conn->prepare("insert into user(user,nick,pass,ip,time) values(?,?,?,?,?)");
$time=(new DateTime())->format("Y-m-d H:i:s");
$pass=md5($pass);
$stmt->bind_param("sssss",$user,$nick,$pass,$ip,$time);
$stmt->execute();
$stmt->close();
//註冊成功
die_json(["ok"=>"ok","data"=>""]);
