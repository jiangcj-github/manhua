<?php
$admin="";
$pass="";

if(isset($_REQUEST["admin"])&&isset($_REQUEST["pass"])){
    $admin=$_REQUEST["admin"];
    $pass=$_REQUEST["pass"];
    if($admin=="lindakai"&&$pass=="20090928"){
        session_start();
        $_SESSION["admin"]="lindakai";
        header("Location:index.php");
        die();
    }
}
?>
<html>
<head>
    <title>Admin</title>
    <style>
        body{margin:0;padding:20px;}
        .admin{}
        .admin .row{padding:3px 0;}
        .admin .row label{display:inline-block;width:100px;font-size:14px;text-align:right;}
        .admin .row button{margin-left:105px;}
    </style>
</head>
<body>
    <form method="post" class="admin">
        <div class="row">
            <label>管理員賬戶：</label>
            <input type="text" name="admin" value="<?php echo $admin ?>">
        </div>
        <div class="row">
            <label>密碼：</label>
            <input type="password" name="pass" value="<?php echo $pass ?>">
        </div>
        <div class="row">
            <button type="submit">提交</button>
        </div>
    </form>
</body>
</html>
