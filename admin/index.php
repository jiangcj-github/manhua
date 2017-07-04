<?php
require("../php/config.php");
include("checkAdmin.php");

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢所有表
$result=$conn->query("SELECT table_name,engine FROM information_schema.tables WHERE engine='InnoDB' AND  table_schema = '".$mysql["database"]."' ORDER BY table_name DESC;");
$data=$result->fetch_all(MYSQLI_ASSOC);
?>
<link href="web/page.css" rel="stylesheet">
<script src="../common/jquery-3.2.1.js"></script>
<div>
    <h1>管理項</h1>
    <a href="initDB.php">initDB</a>
    <a href="units.php">units</a>
    <a href="user.php">user</a>
    <a href="video.php">video</a>
</div>
<div>
    <h1>所有數據</h1>
    <div class="tb_table">
        <div class="tb_header">
            <div class="tb_tr">
                <?php
                if(count($data)>0){
                    foreach ($data[0] as $key=>$value){
                        echo "<div style='width:200px;' class='sortable'>".$key."</div>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="tb_body">
            <?php
            foreach($data as $row){
                echo "<div class='tb_tr'>";
                foreach ($row as $key=>$value){
                    echo "<div style='width:200px'>".$value."</div>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>
<script src="web/page.js"></script>




