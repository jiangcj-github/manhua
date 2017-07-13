<?php
require_once("../../php/config.php");

if(!isset($_REQUEST["mid"])||!isset($_REQUEST["chapter"]) ||!isset($_REQUEST["chapter"])
    ||!isset($_REQUEST["chapter"]) ||!isset($_REQUEST["chapter"])){
    include("../../php/404.php");
}

$mid=$_REQUEST["mid"];
$chapter =$_REQUEST["chapter"];
$user=$_REQUEST["user"];
$date=$_REQUEST["date"];
$text=$_REQUEST["text"];

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if($conn->connect_error){
    die("数据库连接错误");
}
$conn->set_charset("utf8");
$stmt = $conn->prepare("insert into comment(mid,chapter,user,date,text) values(?,?,?,?,?)");
if($stmt){
    $stmt->bind_param("iisss",$mid,$chapter,$user,$date,$text);
    $stmt->execute();
    echo json_encode(["mid"=>$mid,"chapter"=>$chapter,"user"=>$user,"date"=>$date,"text"=>$text]);
    $stmt->close();
}
$conn->close();
