<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>signin</title>
    <style>
        body{font-size:14px;}
        .page{width:96%;margin:10px auto;min-width:1000px;}
        .sec{border:1px solid #A6CBE7;}
        .sec>h3{margin:0;font-size:14px;background: #B1D3E0;padding:0 3px;line-height: 22px;}
        .ip-sec>.info{padding:10px;}
        .login-sec{margin-top:10px;}
        .login-sec>.info{padding:10px;}
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
            <h3>登錄入口</h3>
            <div class="info">
                <form method="post">
                <table>
                    <tbody>
                        <tr><td colspan="2"><span style="font-weight:bold;">提示：您的瀏覽器必須支持cookie，否則系統無法記錄登錄狀態。</span></td></tr>
                        <tr><td style="width:100px;">用戶名:</td><td><input type="text" name="user" value="<?php echo $user ?>"></td></tr>
                        <tr><td style="width:100px;">密碼:</td><td><input type="password" name="pass" value="<?php echo $pass ?>"></td></tr>
                        <tr><td style="width:100px;"></td><td><span class="err"><?php echo $err ?></span></td></tr>
                        <tr><td style="width:100px;"></td><td><input type="submit" class="btn btn1" value="確認"></td></tr>
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
        }, "jsonp");
    </script>
</body>
</html>


