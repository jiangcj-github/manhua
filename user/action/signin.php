<?php
require_once("../../php/config.php");

/**
 * 登錄成功返回{"ok":""}
 * 出錯返回{"msg":"msg-text"}
 */

session_start();
//參數檢查
if(!isset($_REQUEST["user"])||!isset($_REQUEST["pass"])){
    die(json_encode(["msg"=>"用戶名或密碼為空"]));
}
$user=$_REQUEST["user"];
$pass=$_REQUEST["pass"];
//數據庫
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if($conn->connect_error){
    die(json_encode(["msg"=>"連接失敗"]));
}
$conn->set_charset("utf8");
//登錄檢查
$stmt=$conn->prepare("select nick from user where user=? and pass=?");
if($stmt){
    $stmt->bind_param("ss",$user,$pass);
    $stmt->execute();
    $stmt->bind_result($nick);
    $stmt->fetch();
    if($nick===null){
        die(json_encode(["msg"=>"用戶名或密碼不正確"]));
    }
    $stmt->close();
}else{
    die(json_encode(["msg"=>"查詢失敗"]));
}
//更新lastLogin
$stmt = $conn->prepare("update user set lastLogin=? where user=? and pass=?");
if($stmt){
    $lastLogin=(new DateTime())->format("Y-m-d H:i:s");
    $stmt->bind_param("sss",$lastLogin,$user,$pass);
    $stmt->execute();
    $stmt->close();
}else{
    die(json_encode(["msg"=>"查詢失敗"]));
}
//登錄成功
$_SESSION["nick"]=$nick;
die(json_encode(["ok"=>""]));