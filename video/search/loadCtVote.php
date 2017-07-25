<?php
require_once("../../php/global.php");
require_once("../../php/TimeUtil.php");

//參數檢查
if(!isset($_REQUEST["offset"])||!isset($_REQUEST["limit"])){
    die_json(["msg"=>"缺少必要的參數"]);
}
$offset=$_REQUEST["offset"];
$limit=$_REQUEST["limit"];
//數據庫連接
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//獲取randVideo
$stmt=$conn->prepare("select video.*,units.domain from video join units on video.unit=units.id order by up-down desc limit ? offset ?");
$stmt->bind_param("ii",$limit,$offset);
$stmt->execute();
$result=$stmt->get_result();
$vs=$result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
//time格式
foreach($vs as $k=>$v){
    $vs[$k]["time_str"]=time_tran($vs[$k]["time"]);
    $vs[$k]["poster"]=generateResourceUrl($vs[$k]["id"].".png",$vs[$k]["domain"]);
}
die_json(["ok"=>"ok","data"=>$vs]);