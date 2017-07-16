<?php
    session_start();
    $isLogin=isset($_SESSION["login"]);
?>
<link href="/common/common.css" rel="stylesheet">
<style>
    .top{height:26px;line-height:26px;background:#2d2d2d;}
    .topBar-wrap{background:#111;}
    .topBar{color:#fff;width:1070px;margin:0 auto;display:flex;height:60px;}
    .topBar>.brand{font-weight: bold;font-size:40px;}
    .topBar>a{display:inline-block;line-height:60px;color:#fff;padding:0 10px;}
    .sech-group{display:inline-flex;align-items:center;margin-left: 20px;}
    .sech-group .sech{width:400px;height: 30px;border:none;}
    .sech-group .sech-btn{cursor:pointer;background:url(/common/img/btn-search.png);width:40px;height:30px;display:inline-block;border-radius: 0 5px 5px 0;}
    .sech-group .sech-btn:hover{opacity:0.8;}

    .menuBar-wrap{background:#2d2d2d;}
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
        background:#222;
    }
    .menuBar a:first-child{border-left:1px solid #222;}
</style>
<div class="top"></div>
<div class="topBar-wrap">
    <div class="topBar">
        <a class="brand" href="#"><span style="color:#f90">HD</span><span style="color:#ddd;">Porn</span></a>
        <div class="sech-group"><input type="text" class="sech" placeholder="Search..."><span class="sech-btn"></span></div>
    </div>
</div>
<div class="menuBar-wrap">
    <div class="menuBar">
        <a href="">視頻區</a>
        <a href="">漫畫區</a>
        <a href="">圖片區</a>

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