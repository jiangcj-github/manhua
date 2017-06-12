<?php
require("config.php");

if(!isset($_REQUEST["mid"])||!isset($_REQUEST["chapter"]) ||!isset($_REQUEST["chapter"])
    ||!isset($_REQUEST["chapter"]) ||!isset($_REQUEST["chapter"])){
    include("404.php");
}

$mid=$_REQUEST["mid"];
$chapter =$_REQUEST["chapter"] or die("404");
$user=$_REQUEST["user"] or die("404");
$date=$_REQUEST["date"] or die("404");
$text=$_REQUEST["text"] or die("404");

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
