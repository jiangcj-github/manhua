<?php
require("../../../php/global.php");
include("../../checkAdmin.php");

$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢所有表
$result=$conn->query("select * from video");
$data=$result->fetch_all(MYSQLI_ASSOC);
//獲取資源服务器admin token
$ip=$_SERVER["REMOTE_ADDR"];
$secret="coolpeanut2016";
$time=(new DateTime())->getTimestamp();
$_token=md5($ip.$time.$secret);
?>
<html>
<head>
    <title>video</title>
    <link href="../../web/page.css" rel="stylesheet">
    <script src="../../../web/common/jquery-3.2.1.js"></script>
</head>
<body>
    <div>
        <h1>主頁面</h1>
        <a href="../../index.php">主頁</a>
    </div>
    <div>
        <h1>所有數據</h1>
        <div class="tb_table">
            <div class="tb_header">
                <div class="tb_tr">
                    <?php
                    if(count($data)>0){
                        foreach ($data[0] as $key=>$value){
                            echo "<div style='width:50px;' class='sortable'>".$key."</div>";
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
                        echo "<div style='width:50px'>".$value."</div>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <div>
        <h1>操作</h1>
        <h3>刪除</h3>
        <div>
            <input type="text" id="d_id" placeholder="id">
            <button id="d_btn">刪除</button>
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
               url:"action/delete.php",
               data:{id:id},
               success:function(data){
                   if(data.ok){
                       deleteFile(data.data);
                   }else if(data.msg){
                       alert(data.msg);
                   }else{
                       alert("連接失敗");
                   }
               }
           })
        });
        var _token="<?php echo $_token ?>";
        var _time=<?php echo $time ?>;
        function deleteFile(data){
            ajaxForm.action(null,{
                type:"post",
                url:"http://"+data.domain+"/upload/delete.php",
                data:{vid:data.id,_token:_token,_time:_time},
                success:function(data){
                    if(data.ok){
                        location.reload();
                    }else if(data.msg){
                        alert(data.msg);
                    }else{
                        alert("連接失敗");
                    }
                }
            })
        }
    </script>
</body>
</html>

