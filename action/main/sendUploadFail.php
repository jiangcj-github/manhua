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
    die_json(["msg"=>"用戶未登錄"]);
}
$nick=$_SESSION["login"]["nick"];
//參數檢查
if(!isset($_REQUEST["id"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$id=$_REQUEST["id"];
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//刪除記錄
$stmt=$conn->prepare("delete from video where id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
die_json(["ok"=>"ok","data"=>["id"=>$id]]);


