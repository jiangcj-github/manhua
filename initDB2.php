<?php
require_once("./php/config.php");

    //數據庫
    $conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
    if($conn->connect_error){
        die("連接失敗");
    }
    $conn->set_charset("utf8");

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

    //
    $conn->close();