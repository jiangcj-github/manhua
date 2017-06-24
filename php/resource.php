<?php
require("config.php");

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

