<?php
    require_once("../php/config.php");
    session_start();
    $err=null;
    $user=null;
    $nick=null;
    $pass=null;
    $pass1=null;
    if(isset($_REQUEST["user"])&&isset($_REQUEST["nick"])&&isset($_REQUEST["pass"])&&isset($_REQUEST["pass1"])) {
        $user = $_REQUEST["user"];
        $nick = $_REQUEST["nick"];
        $pass = $_REQUEST["pass"];
        $pass1 = $_REQUEST["pass1"];
        $ip=$_REQUEST["ip"];
        $country=$_REQUEST["country"];
        $city=$_REQUEST["city"];
        $err = checkParam($user, $nick, $pass, $pass1);
        if (!$err) {
            $err = checkParamDB($user,$nick,$pass,$ip,$city,$country);
            if (!$err) {
                //註冊成功
                header( "Location:/user/signin.php" );
                exit();
            }
        }
    }
    function checkParam($user,$nick,$pass,$pass1){
        if(preg_match("/^[0-9a-zA-Z_-]{5,15}$/",$user)==0){
            return "用戶名不符合規則";
        }
        if(preg_match("/^[0-9a-zA-Z_-]{8,15}$/",$pass)==0){
            return "密碼不符合規則";
        }
        if($pass!==$pass1){
            return "密碼輸入不一致";
        }
        if(preg_match("/^\S+$/",$nick)==0){
            return "會員名不符合規則";
        }
        return null;
    }
    function checkParamDB($user,$nick,$pass,$ip,$city,$country){
        $err=null;
        //查數據庫
        global $mysql;
        $conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
        $stmt=null;
        if($conn->connect_error){
            $err="連接失敗";
            goto CLEAR;
        }
        $conn->set_charset("utf8");
        //用戶名不能重複
        $stmt=$conn->prepare("select user from user where user=?");
        if($stmt){
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows >= 1) {
                $err="用戶名已經註冊";
                goto CLEAR;
            }
            $stmt->close();
        }
        //暱稱不能重複
        $stmt=$conn->prepare("select nick from user where nick=?");
        if($stmt){
            $stmt->bind_param("s", $nick);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows >= 1) {
                $err="會員名已經註冊";
                goto CLEAR;
            }
            $stmt->close();
        }
        //同一個IP只能註冊3個
        $stmt=$conn->prepare("select user from user where ip=?");
        if($stmt){
            $stmt->bind_param("s", $ip);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 3) {
                $err="您註冊次數過多,已被限制註冊";
                goto CLEAR;
            }
            $stmt->close();
        }
        //寫數據庫
        $stmt=$conn->prepare("insert into user(user,nick,pass,ip,country,city,time) values(?,?,?,?,?,?,?)");
        if($stmt){
            $time=(new DateTime())->format("Y-m-d H:i:s");
            $stmt->bind_param("sssssss",$user,$nick,$pass,$ip,$country,$city,$time);
            $stmt->execute();
            $stmt->close();
        }
        //關閉連接
        CLEAR:
        if($stmt!=null) $stmt->close();
        $conn->close();
        return $err;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>signup</title>
    <style>
        body{font-size:14px;}
        .page{width:96%;margin:10px auto;min-width:1000px;}
        .sec{border:1px solid #A6CBE7;}
        .sec>h3{margin:0;font-size:14px;background: #B1D3E0;padding:0 3px;line-height: 22px;}
        .ip-sec>.info{padding:10px;}
        .login-sec{margin-top:10px;}
        .login-sec>.info{padding:10px;}
        input[type=text],input[type=password]{width:170px;}
    </style>
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page">
        <div class="sec ip-sec">
            <h3>網路信息</h3>
            <div class="info">
                <table>
                    <tbody>
                        <tr><td style="width:100px;">ip:</td><td><span id="ip"></span</td></tr>
                        <tr><td style="width:100px;">country:</td><td><span id="country"></span</td></tr>
                        <tr><td style="width:100px;">city:</td><td><span id="city"></span</td></tr>
                        <tr><td style="width:100px;">loc:</td><td><span id="loc"></span</td></tr>
                        <tr><td style="width:100px;">org:</td><td><span id="org"></span</td></tr>
                        <tr><td style="width:100px;">region:</td><td><span id="region"></span</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="sec login-sec">
            <h3>註冊信息</h3>
            <div class="info">
                <form method="post">
                    <input type="hidden" name="ip" id="ip-signup">
                    <input type="hidden" name="country" id="country-signup">
                    <input type="hidden" name="city" id="city-signup">
                    <table>
                        <tbody>
                            <tr><td style="width:100px;">用戶名:</td><td style="width:180px"><input type="text" name="user" value="<?php echo $user ?>"></td><td>限制(0-9,a-z,A-Z,_,-)組合,5至15個字符</td></tr>
                            <tr><td style="width:100px;">會員名:</td><td style="width:180px"><input type="text" name="nick" value="<?php echo $nick ?>"></td><td>非空字符</td></tr>
                            <tr><td style="width:100px;">密碼:</td><td style="width:180px"><input type="password" name="pass" value="<?php echo $pass ?>"></td><td>限制(0-9,a-z,A-Z,_,-)組合,8至15個字符</td></tr>
                            <tr><td style="width:100px;">重複密碼:</td style="width:180px"><td><input type="password" name="pass1" value="<?php echo $pass1 ?>"><td></td></tr>
                            <tr><td style="width:100px;"></td><td colspan="2"><span class="err"><?php echo $err ?></span></td></tr>
                            <tr><td style="width:100px;"></td><td colspan="2"><input type="submit" class="btn btn1" value="提交"></td></tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <script>
        $.get("http://ipinfo.io", function(response) {
            $("#ip").html(response.ip);
            $("#country").html(response.country);
            $("#city").html(response.city);
            $("#loc").html(response.loc);
            $("#org").html(response.org);
            $("#region").html(response.region);
            $("#ip-signup").val(response.ip);
            $("#country-signup").val(response.country);
            $("#city-signup").val(response.city);
        }, "jsonp");
    </script>
</body>
</html>


