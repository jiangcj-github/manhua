<?php
require_once("../../php/config.php");

if(!isset($_REQUEST["mid"])||!isset($_REQUEST["chapter"]) ||!isset($_REQUEST["offset"])){
    include("../../php/404.php");
}

$mid=$_REQUEST["mid"];
$chapter =$_REQUEST["chapter"];
$offset=$_REQUEST["offset"];

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if($conn->connect_error){
    die("数据库连接错误");
}
$conn->set_charset("utf8");
$stmt = $conn->prepare("select * from comment where mid=? and chapter=? order by date desc limit 10 offset ?");
if($stmt){
    $stmt->bind_param("iii",$mid,$chapter,$offset);
    $stmt->execute();
    $result=$stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    $result->close();
    $stmt->close();
}
$conn->close();
