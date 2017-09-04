<?php
/**
 *  相關配置
 */

//error_reporting(0);

/*調試選項*/
error_reporting(E_ALL);
ini_set("display_errors","on");

/**
 * mysql配置
 */
extension_loaded("mysqli");

$mysql=array(
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
 * 時間設置
 */
date_default_timezone_set("UTC");

/**
 * 返回json
 */
function die_json($data){
    die(json_encode($data));
}
