<?php
require("../php/global.php");
include("checkAdmin.php");

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢所有表
$result=$conn->query("select * from units");
$data=$result->fetch_all(MYSQLI_ASSOC);
?>
<link href="web/page.css" rel="stylesheet">
<script src="../common/jquery-3.2.1.js"></script>
<div>
    <h1>主頁面</h1>
    <a href="index.php">主頁</a>
</div>

<div>
    <h1>所有數據</h1>
    <p>flag: 0表示網站服務器，1表示資源服務器，2表示代理服務器</p>
    <div class="tb_table">
        <div class="tb_header">
            <div class="tb_tr">
                <?php
                if(count($data)>0){
                    foreach ($data[0] as $key=>$value){
                        echo "<div style='width:100px;' class='sortable'>".$key."</div>";
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
                    echo "<div style='width:100px'>".$value."</div>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>
<script src="web/page.js"></script>
