<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>signin</title>
    <link href="page.css" rel="stylesheet">
</head>
<body>
    <?php include("../nav.php") ?>
    <?php
        if($isLogin){
            die("已登錄用戶：".$_SESSION["login"]["nick"]);
        }
    ?>
    <div class="page">
        <div class="sec login-sec">
            <h3>登錄入口</h3>
            <div class="info">
                <table>
                    <tbody>
                        <tr><td colspan="2"><span style="font-weight:bold;">提示：您的瀏覽器必須支持cookie，否則系統無法記錄登錄狀態。</span></td></tr>
                        <tr><td colspan="2"><span style="font-weight:bold;">如果是您的私人設備，請選擇【自動登錄】以提高效率。如果是公共設備，請取消【自動登錄】以便保護您的隱私。<a href="#">詳細</a></span></td></tr>
                        <tr><td style="width:100px;">用戶名:</td><td><input type="text" name="user"></td></tr>
                        <tr><td style="width:100px;">密碼:</td><td><input type="password" name="pass"></td></tr>
                        <tr><td style="width:100px;"></td><td><label style="cursor:pointer;"><input type="checkbox" name="autosign">自動登錄</label></td></tr>
                        <tr><td style="width:100px;"></td><td><span class="err"></span></td></tr>
                        <tr><td style="width:100px;"></td><td><input type="submit" class="btn btn1" value="確認"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="/common/md5.min.js"></script>
    <script>
        function log(msg){
            $(".err").html(msg);
        }
        $("input[type=submit]").click(function(){
            var user=$("[name=user]").val();
            var pass=$("[name=pass]").val();
            var autosign=$("[name=autosign]").is(":checked");
            if(!/^[0-9a-zA-Z_-]{5,15}$/.test(user)||!/^[0-9a-zA-Z_-]{8,15}$/.test(pass)){
                log("用戶名或密碼不正確");
                return;
            }
            pass=md5(pass);
            ajaxForm.action(this,{
               type:"post",
               url:"action/signin.php",
               data:{user:user,pass:pass},
               success:function(data){
                   if(data.ok){
                       if(autosign){
                           setCookie("autosign","auto",365*100);
                           setCookie("user",user,365*100);
                           setCookie("pass",pass,365*100);
                       }
                       location.reload();
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


