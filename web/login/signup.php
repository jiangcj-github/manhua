<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>注册</title>
    <link href="css/page.css" rel="stylesheet">
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page">
        <div class="sec login-sec">
            <h3>注册信息</h3>
            <div class="info">
                <?php
                    if($isLogin){
                        die("已登录用户：".$_SESSION["login"]["nick"]);
                    }
                ?>
                <div class="form form-group">
                    <label for="email">邮箱：</label>
                    <input type="text" id="email" tabindex="1">
                    <span class="info">邮箱地址</span>
                </div>
                <div class="form form-group">
                    <label for="nick">昵称：</label>
                    <input type="text" id="nick" tabindex="2">
                    <span class="info">网站显示名称</span>
                </div>
                <div class="form form-group">
                    <label for="pass1">密码：</label>
                    <input type="text" id="pass1" tabindex="3" class="password">
                    <span class="info">0-9,a-z,A-Z,_,-组合,8-15个字符</span>
                </div>
                <div class="form form-group">
                    <label for="pass2">确认密码：</label>
                    <input type="text" id="pass2" tabindex="4" class="password">
                </div>
                <div class="form btn-group">
                    <button class="btn btn2" id="submit">注&nbsp;册</button>
                    <span class="err"></span>
                </div>
                <div class="form form-group-check">
                    <label></label>
                    <a href="signin.php">登录</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".password").focus(function(){
            $(this).prop("type","password");
        });
    </script>
    <script src="/web/common/md5.min.js"></script>
    <script src="js/signup.js"></script>
</body>
</html>


