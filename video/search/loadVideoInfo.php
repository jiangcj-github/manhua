<?php
require_once("../../php/global.php");
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢
$result=$stmt=$conn->query("select count(id) as count from video");
$data=$result->fetch_all(MYSQLI_ASSOC);
die_json(["ok"=>"ok","data"=>$data]);