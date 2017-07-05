<?php
require_once("../../php/config.php");
require_once("../../php/util.php");

/**
 *  成功返回:{ok:"ok",data:data}
 *  錯誤返回:{msg:msg_text}
 *  異常:其他
 */

//是否登錄
session_start();
if(!isset($_SESSION["login"])){
    die_json(["msg"=>"用戶為登錄"]);
}
$nick=$_SESSION["login"]["nick"];
//參數檢查
if(!isset($_REQUEST["vid"])||!isset($_REQUEST["msg"])||!isset($_REQUEST["pos"])||!isset($_REQUEST["duration"])){
    die_json(["msg"=>"缺少必需的參數"]);
}
$vid=$_REQUEST["vid"];
$msg=$_REQUEST["msg"];
$pos=$_REQUEST["pos"];
$duration=$_REQUEST["duration"];
//參數有效性檢測
if(mb_strlen($msg)<=0||mb_strlen($msg)>15){
    die_json(["msg"=>"文本超過字符數限制"]);
}
if(preg_match("/^\s*$/",$msg)>0){
    die_json(["msg"=>"無效文本"]);
}
if($pos<=0||$pos>=$duration){
    die_json(["msg"=>"無效時間"]);
}
//數據庫操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//彈幕密度控制
$speed=1;   //速度為: 1字符/s
$numRow=5;  //彈道數目
$stmt=$conn->prepare("
    delete from video_barrage 
    where id in (
        select id from (
              select id from video_barrage 
              where vid = ? and pos < ? and ceil(pos + CHAR_LENGTH(msg) / ?) > ?
              order by id desc
              limit 18446744073709551615 offset 5
        ) as tmp
    )
");
$stmt->bind_param("iiii",$vid,$pos,$speed,$numRow);
$stmt->execute();
//插入彈幕
$stmt=$conn->prepare("insert into video_barrage(vid,nick,msg,pos) values(?,?,?,?)");
$stmt->bind_param("issi",$vid,$nick,$msg,$pos);
$stmt->execute();
die_json(["ok"=>"ok","data"=>""]);