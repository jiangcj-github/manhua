<?php
    session_start();
    $isLogin=isset($_SESSION["login"]);
?>
<link href="/common/common.css" rel="stylesheet">
<style>
    .topBar{height:60px;background:#0F7884;color:#fff;}
    .topBar>.brand{font-weight: bold;font-size:40px;letter-spacing: 3px;}
    .topBar>a{display:inline-block;line-height:60px;color:#fff;padding:0 10px;}
    .menuBar{background-color:#B1D3E0;height:28px;color:#004c7d;line-height:28px;font-size:12px;padding:0 10px;}
</style>
<div class="topBar">
    <a class="brand" href="#">網站標題</a>
</div>
<div class="menuBar">
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
            echo "<a href='/user/signout.php'>登出</a>";
        }else{
            echo "<a href='/user/signin.php'>登錄</a>";
        }
    ?>
    &nbsp;<a href="/user/signup.php">免費註冊</a>
</div>
<script>var isLogin=<?php echo $isLogin?1:0 ?>;</script>
<script src="/common/jquery-3.2.1.js"></script>
<script src="/common/common.js"></script>