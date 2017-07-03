<?php
    require_once("php/config.php");

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
    if ($result===true){
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
    if ($result===true){
        echo "comment created"."<br>";
    }else{
        echo "comment created failed"."<br>";
    }

    $conn->close();