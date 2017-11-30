<?php
session_start();
unset($_SESSION["login"]);
echo "SIGNOUT OK";
?>
<script src="/web/common/common.js"></script>
<script>
    delCookie("autosign");
    delCookie("user");
    delCookie("pass");
</script>
