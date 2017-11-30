<?php
require("../../../php/global.php");
include("../../checkAdmin.php");

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢units表
$result=$conn->query("select * from video_feedback where flag=0 order by time asc");
$data=$result->fetch_all(MYSQLI_ASSOC);
?>
<html>
<head>
    <title>feedback管理</title>
    <link href="../../web/page.css" rel="stylesheet">
    <script src="../../../web/common/jquery-3.2.1.js"></script>
</head>
<body>
<div>
    <a href="../../index.php">主頁</a>
</div>
<div>
    <h1>分類</h1>
    <a href="javascript:void(0);">未處理</a>
    <a href="flag1.php">已處理</a>
    <a href="all.php">全部</a>
</div>
<div>
    <h1>所有數據</h1>
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
<?php
    if(count($data)<=0){
        echo "<b>沒有未處理的反饋</b>";
        die();
    }
?>
<div>
    <h1>处理</h1>
    <h3>標記為已處理</h3>
    <div>
        <input type="text" id="d_id" placeholder="id">
        <button id="d_btn">提交</button>
    </div>
</div>
<script src="../../web/page.js"></script>
<script src="/web/common/common.js"></script>
<script>
    $("#d_btn").click(function(){
        var id=$("#d_id").val();
        if(/^\s*$/.test(id)){
            alert("參數不為空");
            return;
        }
        ajaxForm.action(null,{
            url: "action/deal.php",
            data: {id:id},
            success: function (data) {
                if (data.ok) {
                    location.reload();
                } else if (data.msg) {
                    alert(data.msg);
                }
            }
        });
    });
</script>
</body>
</html>
