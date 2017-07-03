<?php

/*
 * 成功返回{"ok":""}
 */

session_start();
unset($_SESSION["nick"]);
echo ["ok"=>""];