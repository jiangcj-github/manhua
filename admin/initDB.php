<?php
require_once("../php/global.php");

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
 * 建unit表
 * flag: 0表示網站服務器，1表示資源服務器,2表示代理服務器
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS units(
        id int(32) NOT NULL AUTO_INCREMENT,
        domain VARCHAR (255) NOT NULL,
        ip VARCHAR (255) NOT NULL,
        flag INT NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
if($result){
    echo "units created"."<br>";
}else {
    echo "units created failed"."<br>";
}

/**
 * 建video表
 * categery取值範圍[2-歐美，1-亞洲]
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS video(
        id int(32) NOT NULL AUTO_INCREMENT,
        filename VARCHAR (255) NOT NULL,
        duration VARCHAR (255) NOT NULL,
        title VARCHAR (255) NOT NULL,
        time VARCHAR (255) NOT NULL,
        lastPlayTime VARCHAR (255),
        categery VARCHAR (255) NULL,
        up int(32) NOT NULL DEFAULT 10,
        down int(32) NOT NULL DEFAULT 10,
        playNum int(32) NOT NULL DEFAULT 10000,
        unit  int(32) NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
if($result){
    echo "video created"."<br>";
}else{
    echo "video created failed"."<br>";
}

/**
 * 建user_played表
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS user_played(
        nick VARCHAR (255) NOT NULL,
        vid int(32) NOT NULL,
        time VARCHAR (255),
        PRIMARY KEY (nick,vid)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if($result){
    echo "user_played created"."<br>";
}else{
    echo "user_played created failed"."<br>";
}

//建video_comment表
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS video_comment(
        id int(32) NOT NULL AUTO_INCREMENT,
        vid int(32) NOT NULL,
        nick VARCHAR (255) NOT NULL,
        text TEXT NOT NULL,
        count int(32) NOT NULL,
        suport INT NOT NULL DEFAULT 0,
        object INT NOT NULL DEFAULT 0,
        time VARCHAR (255) NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
if($result){
    echo "video_comment created"."<br>";
}else{
    echo "video_comment created failed"."<br>";
}

//建video_reply表
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS video_reply(
        id int(32) NOT NULL AUTO_INCREMENT,
        vid int(32) NOT NULL,
        cid int(32) NOT NULL,
        nick VARCHAR (255) NOT NULL,
        text TEXT NOT NULL,
        time VARCHAR (255) NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
if($result){
    echo "video_reply created"."<br>";
}else{
    echo "video_reply created failed"."<br>";
}

/**
 * 建video_barrage表
 * msg限制15個字符以內
 * pos以秒為單位
 * --------------------------------------------
 * 假設每秒s個字符,有m個彈道
 * 則插入條件為: count(insertPos)<=m且insertPos+insertLen/s>=pos,insertPos<=pos+len/s
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS video_barrage(
        id int(32) NOT NULL AUTO_INCREMENT,
        vid int(32) NOT NULL,
        nick VARCHAR (255) NOT NULL,
        msg VARCHAR (255) NOT NULL,
        pos INT NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
if($result){
    echo "video_barrage created"."<br>";
}else{
    echo "video_barrage created failed"."<br>";
}

/**
 * 建user_strict_v表
 * 發送barrage間隔時間60秒
 * 發送comment間隔時間300秒
 * 發送reply間隔時間120秒
 * 發送feedback間隔時間600秒
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS user_strict_v(
        nick VARCHAR (255) NOT NULL,
        barrage VARCHAR (255),
        comment VARCHAR (255),
        reply VARCHAR (255),
        feedback VARCHAR (255),
        PRIMARY KEY (nick)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if($result){
    echo "user_strict_v created"."<br>";
}else{
    echo "user_strict_v created failed"."<br>";
}

/**
 * 建user_strict_v2表
 * 發送vote間隔時間24*60*60,對不同vid,無時間間隔，但24*60*60內限制10次
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS user_strict_v2(
        nick VARCHAR (255) NOT NULL,
        vid int(32) NOT NULL,
        vote VARCHAR (255),
        PRIMARY KEY (nick,vid)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if($result){
    echo "user_strict_v2 created"."<br>";
}else{
    echo "user_strict_v2 created failed"."<br>";
}

/**
 * 建user_strict_v_cm表
 * 對同一個cid
 * 發送suport,object間隔時間24*60*60秒
 * 對不同cid
 * 無間隔時間,但24*60*60秒之內各限10次。
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS user_strict_v_cm(
        nick VARCHAR (255) NOT NULL,
        cid int(32) NOT NULL,
        suport VARCHAR (255),
        object VARCHAR (255),
        PRIMARY KEY (nick,cid)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if($result){
    echo "user_strict_v_cm created"."<br>";
}else{
    echo "user_strict_v_cm created failed"."<br>";
}

/**
 * 建video_feedback表
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS video_feedback(
        id int (32) NOT NULL AUTO_INCREMENT,
        vid int(32) NOT NULL,
        nick VARCHAR (255) NOT NULL,
        msg VARCHAR (255) NOT NULL,
        describ text,
        email VARCHAR (255),
        time VARCHAR (255) NOT NULL,
        PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
if($result){
    echo "video_feedback created"."<br>";
}else{
    echo "video_feedback created failed"."<br>";
}

/**
 *  創建mh_comment表
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS mh_comment (
      id int(32) NOT NULL AUTO_INCREMENT,
      mid int(32) NOT NULL,
      chapter int(32) NOT NULL,
      nick varchar(255) NOT NULL,
      time varchar(255) NOT NULL,
      text text NOT NULL,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    ");
if ($result){
    echo "mh_comment created"."<br>";
}else{
    echo "mh_comment created failed"."<br>";
}

/**
 *  創建user_strict_mh表
 *  發送comment間隔時間120秒
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS user_strict_mh(
      nick varchar(255) NOT NULL,
      comment varchar(255),
      PRIMARY KEY(nick)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
if ($result){
    echo "user_strict_mh created"."<br>";
}else{
    echo "user_strict_mh created failed"."<br>";
}

/**
 *  創建mh表
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS mh(
      id int(32) NOT NULL AUTO_INCREMENT,
      name VARCHAR (255) NOT NULL,
      unit int(32) NOT NULL,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    ");
if ($result){
    echo "mh created"."<br>";
}else{
    echo "mh created failed"."<br>";
}

/**
 *  創建mh_chapter表
 *  chapter不要求連續
 *  page連續，範圍[1,pageNum]
 */
$result=$conn->query("
    CREATE TABLE IF NOT EXISTS mh_chapter(
      mid int(32) NOT NULL,
      chapter float(32) NOT NULL,
      pageNum int(32) NOT NULL,
      PRIMARY KEY (mid,chapter)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
if ($result){
    echo "mh_chapter created"."<br>";
}else{
    echo "mh_chapter created failed"."<br>";
}