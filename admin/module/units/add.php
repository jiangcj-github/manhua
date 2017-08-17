<?php
require("../../../php/global.php");
include("../../checkAdmin.php");

//參數檢查
if(!isset($_REQUEST["domain"])||!isset($_REQUEST["ip"])||!isset($_REQUEST["flag"])){
    die_json(["msg"=>"缺少參數"]);
}
$domain=$_REQUEST["domain"];
$ip=$_REQUEST["ip"];
$flag=$_REQUEST["flag"];
if(preg_match("/^\s*$/",$domain)>0||preg_match("/^\s*$/",$ip)>0||preg_match("/^\s*$/",$flag)>0){
    die_json(["msg"=>"無效參數"]);
}
//寫數據庫
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
$stmt=$conn->prepare("insert into units(domain,ip,flag) values(?,?,?)");
$stmt->bind_param("ssi",$domain,$ip,$flag);
$stmt->execute();
die_json(["ok"=>"ok","data"=>""]);
