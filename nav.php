<?php
    $isLogin=isset($_SESSION["nick"]);
?>
<style>
    body{margin:0;padding:0;background-color:#F7F6F2;font-family:"Tahoma";}
    a{text-decoration:none;}
    .topBar{height:60px;background:#0F7884;color:#fff;}
    .topBar>.brand{font-weight: bold;font-size:40px;letter-spacing: 3px;}
    .topBar>a{display:inline-block;line-height:60px;color:#fff;padding:0 10px;}
    .menuBar{background-color:#B1D3E0;height:28px;color:#004c7d;line-height:28px;font-size:12px;padding:0 10px;}
    .btn{-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}
    .btn1{border: 1px solid #c5abc0;display: inline-block;padding: 2px 10px;cursor: pointer;background: #A6CBE7;}
    .btn1:hover{border:1px solid #aba0a9;box-shadow: 0 0 1px #633359;text-shadow: 0 0 1px #c5abc0;}
    .err{color:red;}
</style>
<div class="topBar">
    <a class="brand" href="#">網站標題</a>
</div>
<div class="menuBar">
    ==<span>會員名稱：</span>
    <span>
        <?php
            if($isLogin){
                echo $_SESSION["nick"];
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
<script src="https://code.jquery.com/jquery-3.2.1.js""></script>