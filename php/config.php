<?php
//error_reporting(0);

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
 * 资源服务器配置
 */
$resourceServer=array(
    "host"=>"lindakai.com"
);

/**
 * 自動構造資源url
 */
function generateResourceUrl($fileName){
    $secret = "lindakai";
    $protectedPath = "/data/";
    $ipLimitation = true;
    $hexTime = dechex(time());
    if ($ipLimitation) {
        $token = md5($secret . $fileName . $hexTime . $_SERVER["REMOTE_ADDR"]);
    }else{
        $token = md5($secret . $fileName. $hexTime);
    }
    global $resourceServer;
    $baseUrl="http://".$resourceServer["host"];
    $url =$baseUrl .$protectedPath . $token. "/" . $hexTime . $fileName;
    return $url;
}
