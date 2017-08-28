<?php
require("../../../../php/global.php");
include("../../../checkAdmin.php");

//參數檢查
if(!isset($_REQUEST["id"])){
    die_json(["msg"=>"缺少參數"]);
}
$id=$_REQUEST["id"];
if(preg_match("/^\s*$/",$id)>0){
    die_json(["msg"=>"無效參數"]);
}
//寫數據庫
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
$stmt=$conn->prepare("delete from units where id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
die_json(["ok"=>"ok","data"=>""]);
