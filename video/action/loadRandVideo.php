<?php
require_once("../../php/config.php");
require_once("../../php/util.php");

/**
 *  成功返回:{ok:"",data:data}
 *  錯誤返回:{msg:msg_text}
 *  異常:其他
 */

//參數檢查
$limit=20;
if(isset($_REQUEST["limit"])){
    $limit=$_REQUEST["limit"];
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢
$stmt=$conn->prepare("select * from video order by rand() limit ?");
$stmt->bind_param("i",$limit);
$stmt->execute();
$result=$stmt->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
die_json(["ok"=>"","data"=>$data]);
