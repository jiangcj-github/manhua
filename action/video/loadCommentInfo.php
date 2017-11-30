<?php
require_once("../../php/global.php");

/**
 *  成功返回:{ok:"ok",data:data}
 *  錯誤返回:{msg:msg_text}
 *  異常:其他
 */

//參數檢查
if(!isset($_REQUEST["vid"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢
$stmt=$conn->prepare("select count(id) as count from video_comment where vid = ?");
$stmt->bind_param("i",$vid);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
die_json(["ok"=>"ok","data"=>["count"=>$count]]);