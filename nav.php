<?php
    session_start();
    $isLogin=isset($_SESSION["login"]);
?>
<link href="/common/common.css" rel="stylesheet">
<style>
    .top{height:26px;line-height:26px;background:#2d2d2d;}
    .topBar-wrap{background:linear-gradient(to bottom,#222,#111);}
    .topBar{color:#fff;width:1070px;margin:0 auto;display:flex;height:60px;}
    .topBar>.brand{font-weight: bold;font-size:40px;}
    .topBar>a{display:inline-block;line-height:60px;color:#fff;padding:0 10px;}
    .topBar .sech-group{display:inline-flex;align-items:center;margin-left: 20px;}
    .topBar .sech-group .sech{width:400px;height: 30px;border:none;border-radius:5px 0 0 5px;}
    .topBar .sech-group .sech-btn{cursor:pointer;background:url(/common/img/btn-search.png);width:40px;height:30px;display:inline-block;border-radius: 0 5px 5px 0;}
    .topBar .sech-group .sech-btn:hover{opacity:0.8;}
    .topBar .btn-wrap{padding:15px 20px;}
    .topBar .btn-wrap a.btn{height:30px;display:inline-flex;align-items:center;padding:0 17px;border-radius:3px;}
    .topBar .btn-wrap a.btn>img{width:14px;height:14px;margin-right:4px;}
    .topBar .btn-wrap a.link{display:inline-block;line-height:30px;color:#ddd;}
    .topBar .btn-wrap a.link:hover{text-decoration:underline;}
    .topBar .btn-wrap span.nick{display:inline-block;line-height:30px;color:#f90;font-weight:bold;}

    .menuBar-wrap{background:linear-gradient(to bottom,#3d3d3d,#2d2d2d);}
    .menuBar{
        width:1070px;
        margin:0 auto;
        height: 30px;
        color: #fff;
        line-height: 30px;
        font-size: 14px;
        font-weight:bold;
        display:flex;
    }
    .menuBar a{
        width:100px;
        text-align:center;
        color:#ddd !important;
        border-right:1px solid #222;
    }
    .menuBar a:hover{
        background:linear-gradient(to bottom,#2d2d2d,#3d3d3d);
    }
    .menuBar a:first-child{border-left:1px solid #222;}
</style>
<div class="top"></div>
<div class="topBar-wrap">
    <div class="topBar">
        <a class="brand" href="#"><span style="color:#f90">HD</span><span style="color:#ddd;">Porn</span></a>
        <div class="sech-group">
            <input type="text" class="sech" placeholder="Search..."><a href="javascript:void(0);" class="sech-btn"></a>
        </div>
        <div class="btn-wrap">
            <a href="javascript:void(0);" target="_blank" class="btn btn2"><img src="/common/img/upload.svg">上傳</a>
        </div>
        <?php if(!$isLogin){ ?>
        <div class="btn-wrap">
            <a href="/user/signin.php" class="link" target="_blank">Signin</a>
            <span>|</span>
            <a href="/user/signup.php" class="link" target="_blank">Signup</a>
        </div>
        <?php }else{ ?>
        <div class="btn-wrap">
            <span class="nick"><?php echo $_SESSION["login"]["nick"] ?></span>
            <span>|</span>
            <a href="/user/signout.php" class="link" target="_blank">Signout</a>
        </div>
        <?php } ?>
    </div>
</div>
<div class="menuBar-wrap">
    <div class="menuBar">
        <a href="">首頁</a>
        <a href="">最新</a>
        <a href="">熱門</a>
        <a href="">亞洲</a>
        <a href="">歐美</a>
        <a href="">使用條款</a>

        <!--
    ==<span>會員名稱：</span>
    <span>
        <?php
        if($isLogin){
            echo $_SESSION["login"]["nick"];
        }else{
            echo "未登錄";
        }
        ?>
    </span>
    ==<span>&nbsp;|&nbsp;</span>
    <?php
        if($isLogin){
            echo "<span>上次登錄：".$_SESSION["login"]["lastLogin"]."</span>&nbsp;|&nbsp;<a href='/user/signout.php' target='_blank'>登出</a>";
        }else{
            echo "<a href='/user/signin.php' target='_blank'>登錄</a> &nbsp;<a href=\"/user/signup.php\" target=\"_blank\">免費註冊</a>";
        }
        ?>
    -->
    </div>
</div>
<script>var isLogin=<?php echo $isLogin?1:0 ?>;</script>
<script src="/common/jquery-3.2.1.js"></script>
<script src="/common/common.js"></script>
<script>
    if(!isLogin && getCookie("autosign")){
        ajaxForm.action(null,{
            type:"post",
            url:"/user/action/signin.php",
            data:{user:getCookie("user"),pass:getCookie("pass")},
            success:function(data){
                if(data.ok){
                    location.reload();
                }
            }
        });
    }
</script>
<?php
    //阻止頁面繼續加載
    if(!$isLogin && isset($_COOKIE["autosign"])){
        die();
    }
?>