<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>signup</title>
    <link href="css/page.css" rel="stylesheet">
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page">
        <div class="sec login-sec">
            <h3>註冊信息</h3>
            <div class="info">
                <?php
                    if($isLogin){
                        die("已登錄用戶：".$_SESSION["login"]["nick"]);
                    }
                ?>
                <table>
                    <tbody>
                        <tr><td style="width:100px;">用戶名:</td><td style="width:180px"><input type="text" name="user"></td><td>限制(0-9,a-z,A-Z,_,-)組合,5至15個字符</td></tr>
                        <tr><td style="width:100px;">會員名:</td><td style="width:180px"><input type="text" name="nick"></td><td>非空字符</td></tr>
                        <tr><td style="width:100px;">密碼:</td><td style="width:180px"><input type="password" name="pass"></td><td>限制(0-9,a-z,A-Z,_,-)組合,8至15個字符</td></tr>
                        <tr><td style="width:100px;">重複密碼:</td style="width:180px"><td><input type="password" name="pass1"><td></td></tr>
                        <tr><td style="width:100px;"></td><td colspan="2"><span class="err"></span></td></tr>
                        <tr><td style="width:100px;"></td><td colspan="2"><input type="submit" class="btn btn2" value="提交"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function log(msg){
            $(".err").html(msg);
        }
        $("input[type=submit]").click(function(){
            var user=$("[name=user]").val();
            var nick=$("[name=nick]").val();
            var pass=$("[name=pass]").val();
            var pass1=$("[name=pass1]").val();
            if(!/^[0-9a-zA-Z_-]{5,15}$/.test(user)){
                log("用戶名不符合規則");
                return;
            }
            if(!/^[0-9a-zA-Z_-]{8,15}$/.test(pass)){
                log("密碼不符合規則");
                return;
            }
            if(pass!=pass1){
                log("密碼輸入不一致");
                return;
            }
            if(!/^\S+$/.test(nick)){
                log("會員名不符合規則");
                return;
            }
            ajaxForm.action(this,{
               type:"post",
                url:"action/signup.php",
                data:{user:user,nick:nick,pass:pass,pass1:pass1},
                success:function(data){
                    if(data.ok){
                        location.href="signin.php";
                    }else if(data.msg){
                        log(data.msg);
                    }else{
                        log("查詢出錯");
                    }
                }
            });
        });
    </script>
</body>
</html>


