<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>登录</title>
    <link href="css/page.css" rel="stylesheet">
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page">
        <div class="sec login-sec">
            <h3>登录入口</h3>
            <div class="info">
                <?php
                    if($isLogin){
                        die("已登录用户：".$_SESSION["login"]["nick"]);
                    }
                ?>
                <div class="form form-group">
                    <label for="email">邮箱：</label>
                    <input type="text" id="email" tabindex="1">
                </div>
                <div class="form form-group">
                    <label for="pass">密码：</label>
                    <input type="text" id="pass" tabindex="2" class="password">
                </div>
                <div class="form btn-group">
                    <button class="btn btn2" id="submit" tabindex="3">登&nbsp;录</button>
                    <span class="err"></span>
                </div>
                <div class="form form-group-check">
                    <label><input type="checkbox" id="auto">自动登录</label>
                    <a href="signup.php">注册新账户</a>
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
    <script src="js/signin.js"></script>
</body>
</html>


