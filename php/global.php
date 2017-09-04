<?php

/**
 *  相關配置
 */

//error_reporting(0);
error_reporting(E_ALL);

/**
 * mysql配置
 */
$mysql=array(
    //"host"=>"192.241.217.195",
    "host"=>"localhost",
    "user"=>"root",
    "password"=>"root",
    "database"=>"manhua"
);

/**
 * 自動構造資源url
 */
function generateResourceUrl($fileName,$domain){
    $secret = "lindakai";
    $protectedPath = "/data/";
    $ipLimitation = true;
    $hexTime = dechex(time());
    $fileName="/".$fileName;
    if ($ipLimitation) {
        $token = md5($secret . $fileName . $hexTime . $_SERVER["REMOTE_ADDR"]);
    }else{
        $token = md5($secret . $fileName. $hexTime);
    }
    $baseUrl="http://".$domain;
    $url =$baseUrl .$protectedPath . $token. "/" . $hexTime . $fileName;
    return $url;
}

/**
 * 返回json
 */
function die_json($data){
    die(json_encode($data));
}
