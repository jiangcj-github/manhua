<?php
require_once("../../php/global.php");

/**
 *  成功返回:{ok:"ok",data:data}
 *  錯誤返回:{msg:msg_text}
 *  異常:其他
 */

session_start();
//參數檢查
if(!isset($_REQUEST["email"])||!isset($_REQUEST["pass"])){
    die_json(["msg"=>"缺少参数"]);
}
$user=$_REQUEST["email"];
$pass=$_REQUEST["pass"];
//數據庫
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//登錄檢查
$stmt=$conn->prepare("select nick,time,lastLogin from user where user=? and pass=?");
$stmt->bind_param("ss",$user,$pass);
$stmt->execute();
$result=$stmt->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
if(count($data)<=0){
    die_json(["msg"=>"邮箱或密码不正确"]);
}
$stmt->close();
$loginUser=$data[0];
//更新lastLogin
$stmt = $conn->prepare("update user set lastLogin=? where user=? and pass=?");
$lastLogin1=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("sss",$lastLogin1,$user,$pass);
$stmt->execute();
$stmt->close();
//登錄成功
$_SESSION["login"]=["user"=>$user,"nick"=>$loginUser["nick"],"time"=>$loginUser["time"],"lastLogin"=>$loginUser["lastLogin"]];
die_json(["ok"=>"ok","data"=>""]);