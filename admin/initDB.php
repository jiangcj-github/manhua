<?php
require_once("../php/config.php");

include("checkAdmin.php");

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if($conn->connect_error){
    die("數據庫連接錯誤");
}
$conn->set_charset("utf8");

/**
 *  創建user表
 *  1.同一個IP不超過3個帳戶
 *  2.user不能重複
 *  3,nick不能重複
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS  user(
        user VARCHAR (255) UNIQUE NOT NULL,
        nick VARCHAR (255) UNIQUE NOT NULL,
        pass VARCHAR (255) NOT NULL,
        ip VARCHAR (255) NOT NULL,
        country VARCHAR (255) NOT NULL,
        city VARCHAR (255) NOT NULL,
        time VARCHAR (255) NOT NULL,
        lastLogin VARCHAR (255),
        PRIMARY KEY(user)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if ($result){
    echo "user created"."<br>";
}else{
    echo "user created failed"."<br>";
}

/**
 *  創建comment表
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS comment (
      id int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
      mid int(11) NOT NULL,
      chapter int(11) NOT NULL,
      user varchar(255) NOT NULL,
      date varchar(255) NOT NULL,
      text varchar(255) NOT NULL,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    ");
if ($result){
    echo "comment created"."<br>";
}else{
    echo "comment created failed"."<br>";
}

/**
 * 建unit表
 * flag: 0表示網站服務器，1表示資源服務器,2表示代理服務器
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS units(
        id INT NOT NULL AUTO_INCREMENT,
        domain VARCHAR (255) NOT NULL,
        ip VARCHAR (255) NOT NULL,
        flag INT NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;;
");
if($result){
    echo "units created"."<br>";
}else {
    echo "units created failed"."<br>";
}

//建video表
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS video(
        id INT NOT NULL AUTO_INCREMENT,
        filename VARCHAR (255) NOT NULL,
        duration VARCHAR (255) NOT NULL,
        unit  INT NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;;
");
if($result){
    echo "video created"."<br>";
}else{
    echo "video created failed"."<br>";
}

//建video_comment表
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS video_comment(
        id INT NOT NULL AUTO_INCREMENT,
        vid INT NOT NULL,
        nick VARCHAR (255) NOT NULL,
        text TEXT NOT NULL,
        time VARCHAR (255) NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;;
");
if($result){
    echo "video_comment created"."<br>";
}else{
    echo "video_comment created failed"."<br>";
}

/**
 * 建video_barrage表
 * msg限制15個字符以內
 * pos以秒為單位
 * --------------------------------------------
 * 假設每秒s個字符,有m個彈道
 * 則插入條件為: count(insertPos)<=m且pos<insertPos<pos+len/s
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS video_barrage(
        id INT NOT NULL AUTO_INCREMENT,
        vid INT NOT NULL,
        nick VARCHAR (255) NOT NULL,
        msg VARCHAR (255) NOT NULL,
        pos INT NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;;
");
if($result){
    echo "video_barrage created"."<br>";
}else{
    echo "video_barrage created failed"."<br>";
}