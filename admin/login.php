<?php
require("../php/config.php");

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

<form method="post">
<input type="text" name="admin" value="<?php echo $admin ?>">
<input type="password" name="pass" value="<?php echo $pass ?>">
<button type="submit">提交</button>
</form>