<?php
require_once("../../php/global.php");

//參數檢查
if(!isset($_REQUEST["mid"])||!isset($_REQUEST["chapter"])){
    die_json(["msg"=>"缺少必要的參數"]);
}
$mid=$_REQUEST["mid"];
$chapter =$_REQUEST["chapter"];
$offset=0;
if(isset($_REQUEST["offset"])){
    $offset=$_REQUEST["offset"];
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
$stmt = $conn->prepare("select * from mh_comment where mid=? and chapter=? order by time desc limit 10 offset ?");
$stmt->bind_param("iii",$mid,$chapter,$offset);
$stmt->execute();
$result=$stmt->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
die_json(["ok"=>"ok","data"=>$data]);

