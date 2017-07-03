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


