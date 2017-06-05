<?php
require("config.php");

$mid = isset($_GET["mid"]) or die("404");
$chapter = isset($_GET["chapter"]) or die("404");
$offset = isset($_GET["offset"]) or die("404");

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
if ($conn->connect_error) {
    die("数据库连接错误");
}
$sql = "select * from comment";
$result = $conn->query($sql);
if()
while($row = $result->fetch_assoc()){
    //$row["id"]
}
$conn->close();
