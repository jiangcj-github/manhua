<?php
require("../../../php/global.php");
include("../../checkAdmin.php");

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢units表
$result=$conn->query("select * from units");
$data=$result->fetch_all(MYSQLI_ASSOC);
?>
<html>
<head>
    <title>Units管理</title>
    <link href="../../web/page.css" rel="stylesheet">
    <script src="../../../common/jquery-3.2.1.js"></script>
</head>
<body>
    <div>
        <a href="../../index.php">主頁</a>
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
    <div>
        <h1>操作</h1>
        <h3>添加</h3>
        <div>
            <input type="text" id="a_domain" placeholder="domain">
            <input type="text" id="a_ip" placeholder="ip">
            <input type="text" id="a_flag" placeholder="flag">
            <button id="a_btn">添加</button>
            <div>domain,ip,flag非空</div>
        </div>
        <h3>修改</h3>
        <div>
            <input type="text" id="m_id" placeholder="id">
            <input type="text" id="m_domain" placeholder="domain">
            <input type="text" id="m_ip" placeholder="ip">
            <input type="text" id="m_flag" placeholder="flag">
            <button id="m_btn">修改</button>
            <div>id,domain,ip,flag非空</div>
        </div>
        <h3>刪除</h3>
        <div>
            <input type="text" id="d_id" placeholder="id">
            <button id="d_btn">刪除</button>
        </div>
    </div>
    <script src="../../web/page.js"></script>
    <script src="/common/common.js"></script>
    <script>
        $("#a_btn").click(function() {
            var domain = $("#a_domain").val();
            var ip = $("#a_ip").val();
            var flag = $("#a_flag").val();
            if (/^\s*$/.test(domain) || /^\s*$/.test(ip) || /^\s*$/.test(flag)) {
                alert("參數不為空");
                return;
            }
            ajaxForm.action(null,{
                url: "action/add.php",
                data: {domain: domain, ip: ip, flag: flag},
                success: function (data) {
                    if (data.ok) {
                        location.reload();
                    } else if (data.msg) {
                        alert(data.msg);
                    }
                }
            });
        });
        $("#m_btn").click(function(){
            var id=$("#m_id").val();
            var domain=$("#m_domain").val();
            var ip=$("#m_ip").val();
            var flag=$("#m_flag").val();
            if(/^\s*$/.test(id)||/^\s*$/.test(domain)||/^\s*$/.test(ip)||/^\s*$/.test(flag)){
                alert("參數不為空");
                return;
            }
            ajaxForm.action(null,{
                url: "action/modify.php",
                data: {id:id,domain:domain,ip:ip,flag:flag},
                success: function (data) {
                    if (data.ok) {
                        location.reload();
                    } else if (data.msg) {
                        alert(data.msg);
                    }
                }
            });
        });
        $("#d_btn").click(function(){
            var id=$("#d_id").val();
            if(/^\s*$/.test(id)){
                alert("參數不為空");
                return;
            }
            ajaxForm.action(null,{
                url: "action/delete.php",
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
