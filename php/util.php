<?php

/**
 * 工具封裝
 */

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