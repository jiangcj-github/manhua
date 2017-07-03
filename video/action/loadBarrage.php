<?php
require_once("../../php/config.php");

//參數檢查
if(!isset($_REQUEST["vid"])){
    die(json_encode(["msg"=>"缺少參數vid"]));
}
$vid=$_REQUEST["vid"];
$limit=18446744073709551615;
$offset=0;
if(isset($_REQUEST["limit"])){
    $limit=$_REQUEST["limit"];
}
if(isset($_REQUEST["offset"])){
    $offset=$_REQUEST["offset"];
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if($conn->connect_error){
    die(json_encode(["msg"=>"連接失敗"]));
}
$conn->set_charset("utf8");
//查詢
$stmt=$conn->prepare("select * from video_barrage where vid = ? order by id desc limit ? offset ?");
if($stmt){
    $stmt->bind_param("iii",$vid,$limit,$offset);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result){
        $data=$result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
        $result->close();
    }
    $stmt->close();
}
$conn->close();