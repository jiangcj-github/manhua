<?php
    isset($_SESSION) or session_start();
    $isLogin=isset($_SESSION["login"]);
?>
<link rel="shortcut icon" href="/favicon.png"/>
<link href="/web/common/common.css" rel="stylesheet"/>
<style>
    .top{height:26px;line-height:26px;background:#2d2d2d;}
    .top-inner{width:1070px;margin:0 auto;}
    .top .top-inner a{color:#ddd;display:inline-block;line-height:26px;font-size:14px;padding:0 5px;}
    .topBar-wrap{background:linear-gradient(to bottom,#222,#111);}
    .topBar{color:#fff;width:1070px;margin:0 auto;display:flex;height:60px;}
    .topBar>.brand{font-weight: bold;font-size:40px;}
    .topBar>a{display:inline-block;line-height:60px;color:#fff;padding:0 10px;}
    .topBar .sech-group{display:inline-flex;align-items:center;margin-left: 20px;}
    .topBar .sech-group .sech{width:400px;height: 30px;border:none;border-radius:5px 0 0 5px;}
    .topBar .sech-group .sech-btn{cursor:pointer;background:url(/web/common/img/btn-search.png);width:40px;height:30px;display:inline-block;border-radius: 0 5px 5px 0;}
    .topBar .sech-group .sech-btn:hover{opacity:0.8;}
    .topBar .btn-wrap{padding:15px 20px;}
    .topBar .btn-wrap a.btn{height:30px;display:inline-flex;align-items:center;padding:0 17px;border-radius:3px;}
    .topBar .btn-wrap a.btn>img{width:14px;height:14px;margin-right:4px;}
    .topBar .btn-wrap a.link{display:inline-block;line-height:30px;color:#ddd;font-family:"Museo Sans",Arial,Helvetica,sans-serif;}
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
    .menuBar a{width:100px;text-align:center;color:#ddd !important;border-right:1px solid #222;}
    .menuBar a:hover{background:linear-gradient(to bottom,#2d2d2d,#3d3d3d);}
    .menuBar a:first-child{border-left:1px solid #222;}
</style>
<div class="top">
    <div class="top-inner">
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
        <a href="#">site1</a>
    </div>
</div>
<div class="topBar-wrap">
    <div class="topBar">
        <a class="brand" href="#"><span style="color:#f90">PA</span><span style="color:#ddd;">404</span></a>
        <div class="sech-group">
            <input type="text" class="sech" placeholder="Search..."><a href="javascript:void(0);" class="sech-btn"></a>
        </div>
        <div class="btn-wrap">
            <a href="/web/play/upload.php" class="btn btn2"><img src="/web/common/img/upload.svg">上傳</a>
        </div>
        <?php if(!$isLogin){ ?>
        <div class="btn-wrap">
            <a href="/web/login/signin.php" class="link" target="_blank">登錄</a>
            <span>|</span>
            <a href="/web/login/signup.php" class="link" target="_blank">註冊</a>
        </div>
        <?php }else{ ?>
        <div class="btn-wrap">
            <span class="nick"><?php echo $_SESSION["login"]["nick"] ?></span>
            <span>|</span>
            <a href="/web/login/signout.php" class="link" target="_blank">註銷</a>
        </div>
        <?php } ?>
    </div>
</div>
<div class="menuBar-wrap">
    <div class="menuBar">
        <a href="/web/main/index.php">首頁</a>
        <a href="/web/main/ct_time.php">最新</a>
        <a href="/web/main/ct_vote.php">熱門</a>
        <a href="/web/main/ct_cat1.php?categery=1">亞洲</a>
        <a href="/web/main/ct_cat1.php?categery=2">歐美</a>
        <a href="">使用條款</a>
    </div>
</div>
<script>var isLogin=<?php echo $isLogin?1:0 ?>;</script>
<script src="/web/common/jquery-3.2.1.js"></script>
<script src="/web/common/common.js"></script>
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
<script>
    $(".sech").bind("input",function(){
        var key=$(".sech").val().replace(/\s/g,"");
        if(key.length<=0||key.length>20){
            $(".sech-btn").prop("href","javascript:void(0);");
        }else{
            $(".sech-btn").prop("href","/video/search.php?key="+key);
        }
    });
</script>
