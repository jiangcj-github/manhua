<?php

require_once("../php/config.php");
require_once("../php/util.php");

if(!isset($_REQUEST["id"])){
    die("404");
}
$id=$_REQUEST["id"];
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢video
$stmt=$conn->prepare("select * from video where id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($id,$filename,$duration,$unit);
if(!$stmt->fetch()){
    die("404");
}
$stmt->close();
//查詢units
$stmt=$conn->prepare("select domain from units where id = ?");
$stmt->bind_param("i",$unit);
$stmt->execute();
$stmt->bind_result($domain);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>play</title>
    <link href="web/videojs/video-js.css" rel="stylesheet">
    <link href="web/videojs/video-js-custom.css" rel="stylesheet">
    <script src="web/videojs/video.js"></script>
    <style>
        .out-div{position:relative !important;width:400px !important;}

    </style>
</head>
<body>
    <?php include("../nav.php") ?>

    <div class="out-div">
        <video class="video-js" id="v1" controls preload="auto" width="400">

            <!--<source src="<?php echo generateResourceUrl($filename,$domain) ?>" type="video/mp4">-->
            <source src="web/test.mp4" type="video/mp4">
        </video>
        <!--
        <div class="barg-div">
            <div class="path"><span style="left:10px;">的的的方法的的的方法的的的方法</span><span style="left:10px;">的的的方法</span></div>
            <div class="path">的的的方法</div>
            <div class="path">的的的方法</div>
            <div class="path">的的的方法</div>
        </div>
        -->
    </div>

    <input type="hidden" id="v_id" value="<?php echo $id ?>">
    <input type="hidden" id="v_duration" value="<?php echo $duration ?>">

    <input type="text" id="bg-text"><button id="bg-submit">提交</button>

    <textarea id="cm-text"></textarea><button id="cm-submit">提交</button>


    <script src="web/js/page.js"></script>
<script>
    var options = {};
    var player = videojs("v1", options, function(){
        var speed=3;
        this.on("durationchange",function(){
            var duration=this.duration();
            var vid=$("#v_id").val();
            ajaxForm.action(null,{
                url:"action/loadBarrage.php",
                data:{vid:vid},
                success:function(data){
                    if(data.ok){
                        var html=$("<div class='barg-div'></div>");
                        var path=$("<div class='path'></div>").css("width",duration*speed*16+"px");
                        html.append(path.clone());
                        html.append(path.clone());
                        html.append(path.clone());
                        html.append(path.clone());
                        html.append(path.clone());
                        for(var i=0;i<data.data.length;i++){
                            var span=$("<span></span>").css("left",data.data[i].pos*speed*16+"px").html(data.data[i].msg);
                            html.find(".path").eq(i%5).append(span);
                        }
                        $(".video-js").append(html);
                    }
                }
            });
        });
        this.on("timeupdate",function(){
            $(".barg-div") && $(".barg-div>.path").css("left",-this.currentTime()*speed*16+"px");
        });
    });
    function log1(msg){
        console.log(msg);
    }
    $("#bg-submit").click(function(){
        var msg=$("#bg-text").val();
        var vid=$("#v_id").val();
        var pos=player.currentTime();
        var duration=player.duration();
        if(!isLogin){
            log1("您還未登錄");
            return;
        }
        if(pos<=0||pos>=duration){
            log1("無效時間");
            return;
        }
        if(/^\s*$/.test(msg)){
            log1("無效文本");
            return;
        }
        if(msg.length<=0||msg.length>15){
            log1("文本超過字符數限制");
            return;
        }
        $.post("action/sendBarrage.php",{vid:vid,msg:msg,pos:pos,duration:duration},function(data){
            if(data.ok){

            }else if(data.msg){
                log1(data.msg);
            }else{
                log1("查詢失敗");
            }
        });
    });
    function log2(msg){
        console.log(msg);
    }
    $("#cm-submit").click(function(){
        var vid=$("#v_id").val();
        var text=$("#cm-text").val();
        if(!isLogin){
            log2("您還為登錄");
            return;
        }
        if(/^\s*$/.test(text)){
            log2("文本為空");
            return;
        }
        $.post("action/sendComment.php",{vid:vid,text:text},function(data){
            if(data.ok){

            }else if(data.msg){
                log2(data.msg);
            }else{
                log2("查詢失敗");
            }
        });
    });
</script>
</body>
</html>