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
    <link href="web/css/page.css" rel="stylesheet">
    <link href="/common/honeySwitch/honeySwitch.css" rel="stylesheet">
    <script src="web/videojs/video.js"></script>
    <style>
        .page{width:80%;margin:20px auto;background:#fff;border:1px solid #ccc;}
        .page.col2{display:flex;min-width:1020px;max-width:1050px;}
        .page.col2>.left{flex-grow:1;}
        .page.col2>.right{border-left:1px solid #ccc;width:220px;}

        .sec{padding:20px;border-bottom:1px solid #ccc;}

        .v-div{position:relative !important;height:400px;border-bottom:none;}
        .video-js{width:100%;height:100%;}

        .bg-div{line-height: 30px;border-bottom: 1px solid #ccc;padding: 0 20px 20px 20px;margin-top: -10px;display:flex;}
        .bg-div .bg-toggle{margin-right:10px;height:30px;}

        .bg-div .input-group{display:inline-flex;height:30px;flex-grow:1;}
        .bg-div input[type=text]{border-color:#A6CBE7;border-right:none;flex-grow:1;}
        input[type=text]{padding:0 10px;}

        .sm-div{}
        .sm-div textarea{outline:none;resize:vertical;width:100%;min-height:100px;box-sizing: border-box;margin-bottom:5px;padding:10px;}

        .cm-div{}
        .cm-div .li{display:flex;border:1px solid #e3e3e3;border-bottom:none;}
        .cm-div .li:nth-last-child(2){border-bottom:1px solid #e3e3e3;}
        .cm-div .li_l{width:130px;border-right:1px solid #e3e3e3;text-align:center;padding:10px 0;flex-shrink:0;}
        .cm-div .head{width:80px;height:80px;border:1px solid #41c7db;}
        .cm-div .nick{font-size: 14px;line-height: 26px;text-overflow:ellipsis;color: darkgoldenrod;font-weight:bold;}
        .cm-div .li_r{flex-grow:1;padding:20px;}
        .cm-div .r_c{min-height:180px;}
        .cm-div .r_b{line-height: 20px;text-align: right;padding:10px 20px;}
        .cm-div .r_b span{margin-left:3px;color:gray;}

        .cm-div .r_re{border: 1px solid #e3e3e3;background:#FFFAFA;}
        .cm-div .re_li{border-bottom:1px solid #e3e3e3;min-height:60px;display:flex;}
        .cm-div .re_li_l{flex-shrink:0;text-align:center;padding:10px;}
        .cm-div .re_li_l img{width:48px;height:48px;border:1px solid #e3e3e3;}
        .cm-div .re_li_r{flex-grow:1;padding:10px;}
        .cm-div .re_li_r_c{}
        .cm-div .re_li_r_c .nick:after{content:"：";}
        .cm-div .re_li_r_b{line-height: 20px;text-align:right;color:gray;}
        .cm-div .re_sd{display:flex;height:30px;}
        .cm-div .re_sd input{flex-grow:1;}
        .cm-div .re_sd button{flex-shrink:0;width:70px;}

        .cm-div .li-page{margin-top:10px;text-align:right;}
        .cm-div .li-page a{
            display: inline-block;
            padding: 5px 9px;
            font-size: 12px;
            background: #fff;
            color: #666;
            border: 1px solid #e6e6e6;
        }
        .cm-div .li-page a:hover{color: #3e89fa;border: 1px solid #3e89fa;}
        .cm-div .li-page a.active{border:none;}

        .pane{padding:10px;border-bottom: 1px solid #ccc;}
        .pane>h3{line-height:20px;padding:3px 5px;margin:0 0 3px 0;font-size:14px;color:#6f6f6f;}
        .pane>.item-v{margin:10px 0;width:185px;height:100px;}
        .pane>.item-a{line-height:26px;}
        .pane>.item-a:before{content:"»";}
        .pane>.item-img{}
        .pane>.item-img>img{width:200px;}

        .label1{background: #FF7F42;color:#fff !important;padding:0 5px;border-radius: 5px;}

    </style>
</head>
<body>
    <?php include("../nav.php") ?>
    <div class="page col2">
        <div class="left">
            <div class="sec v-div">
                <video class="video-js" id="v1" controls preload="auto">

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
            <div class=" bg-div">
                <div class="bg-toggle">
                   <span class="switch-on" id="bg-toggle"></span>
                </div>
                <div class="input-group"><input type="text" id="bg-text" placeholder="說點什麼吧，不超過15個字">
                    <button id="bg-submit" class="btn btn2">推送彈幕</button></div></td>
            </div>
            <input type="hidden" id="v_id" value="<?php echo $id ?>">
            <input type="hidden" id="v_duration" value="<?php echo $duration ?>">

            <div class="sec sm-div">
                <textarea id="cm-text"></textarea>
                <button id="cm-submit" class="btn btn2 btn-lg">提交</button>
            </div>

            <div class="sec cm-div">
                <div class="li">
                    <div class="li_l">
                        <img class="head" src="web/1.png">
                        <div class="nick">林打開的</div>
                    </div>
                    <div class="li_r">
                        <div class="r_c">
                            还有一点，我觉得他也是在保护乔，接下去接的这部剧不是爱情剧，而是硬汉电影，这样大家也不会在乔妹和下个女主间有争议，关键同是演军人！
                        </div>
                        <div class="r_b">
                            <span class="label1">21樓</span>
                            <span>2012-12-01 23:23:33</span>
                            <span><a href="#">頂[0]</a></span>
                            <span><a href="#">踩[2]</a></span>
                            <span><a href="#">回復[4]</a></span>
                        </div>
                        <div class="r_re">
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                            <div class="re_sd" data-cid="">
                                <input type="text" placeholder="說點什麼吧"><button class="btn btn2">回復</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li">
                    <div class="li_l">
                        <img class="head" src="web/1.png">
                        <div class="nick">林打開的</div>
                    </div>
                    <div class="li_r">
                        <div class="r_c">
                            还有一点，我觉得他也是在保护乔，接下去接的这部剧不是爱情剧，而是硬汉电影，这样大家也不会在乔妹和下个女主间有争议，关键同是演军人！
                        </div>
                        <div class="r_b">
                            <span class="label1">21樓</span>
                            <span>2012-12-01 23:23:33</span>
                            <span><a href="#">頂[0]</a></span>
                            <span><a href="#">踩[2]</a></span>
                            <span><a href="#">回復[4]</a></span>
                        </div>
                        <div class="r_re">
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="li">
                    <div class="li_l">
                        <img class="head" src="web/1.png">
                        <div class="nick">林打開的</div>
                    </div>
                    <div class="li_r">
                        <div class="r_c">
                            还有一点，我觉得他也是在保护乔，接下去接的这部剧不是爱情剧，而是硬汉电影，这样大家也不会在乔妹和下个女主间有争议，关键同是演军人！
                        </div>
                        <div class="r_b">
                            <span class="label1">21樓</span>
                            <span>2012-12-01 23:23:33</span>
                            <span><a href="#">頂[0]</a></span>
                            <span><a href="#">踩[2]</a></span>
                            <span><a href="#">回復[4]</a></span>
                        </div>
                        <div class="r_re">
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="web/1.png">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">林打開</span>这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下这个要解释一下，小宋先接的电影再接的剧</div>
                                    <div class="re_li_r_b">1222-22-32 33:43:12</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="li-page">
                    <a href="#">上一頁</a>
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">下一頁</a>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="pane">
                <h3>面板1</h3>
                <div class="item-v vpre">
                    <div class="label">12:00</div>
                    <img src="web/1.png">
                </div>
                <div class="item-v vpre">
                    <div class="label">12:00</div>
                    <img src="web/1.png">
                </div>
                <div class="item-v vpre">
                    <div class="label">12:00</div>
                    <img src="web/1.png">
                </div>
            </div>
            <div class="pane">
                <h3>面板2</h3>
                <div class="item-a">
                   <a href="#">李昌钰:章莹颖可能活着</a>
                </div>
                <div class="item-a">
                    <a href="#">斯诺克世界杯中国超神</a>
                </div>
                <div class="item-a">
                    <a href="#">斯诺克世界杯中国超神</a>
                </div>
            </div>
            <div class="pane">
                <h3>面板3</h3>
                <div class="item-img">
                    <img src="web/1.png">
                </div>
            </div>
        </div>
    </div>

    <script src="web/js/page.js"></script>
    <script src="/common/template-web.js"></script>
    <script src="/common/honeySwitch/honeySwitch.js"></script>
    <script id="cm-li" type="text/html">
        <div class="li">
            <div class="li_l">
                <img class="head" src="web/1.png">
                <div class="nick">{{cm.nick}}</div>
            </div>
            <div class="li_r">
                <div class="r_c">{{cm.text}}</div>
                <div class="r_b">
                    <span class="label1">{{cm.count}}樓</span>
                    <span>{{cm.time}}</span>
                    <span><a href="#">頂[{{cm.suport}}]</a></span>
                    <span><a href="#">踩[{{cm.object}}]</a></span>
                    <span><a href="#">回復[{{cm.reply.length}}]</a></span>
                </div>
                <div class="r_re">
                    <% for(var i=0;i<cm.reply.length;i++){ %>
                    <div class="re_li">
                        <div class="re_li_l">
                            <img src="web/1.png">
                        </div>
                        <div class="re_li_r">
                            <div class="re_li_r_c"><span class="nick">{{cm.reply[i].nick}}</span>{{cm.reply[i].text}}</div>
                            <div class="re_li_r_b">{{cm.reply[i].time}}</div>
                        </div>
                    </div>
                    <% } %>
                    <div class="re_sd" data-cid="{{cm.id}}">
                        <input type="text" placeholder="說點什麼吧"><button class="btn btn2" onclick="sendReply(this)">回復</button>
                    </div>
                </div>
            </div>
        </div>
    </script>
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
        //barrage
        $(function(){switchEvent("#bg-toggle",
            function(){
                $(".barg-div").show();
            },function(){
                $(".barg-div").hide();
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
            ajaxForm.action(this,{
                type:"post",
                url:"action/sendBarrage.php",
                data:{vid:vid,msg:msg,pos:pos,duration:duration},
                success:function(data){
                    if(data.ok){

                    }else if(data.msg){
                        log1(data.msg);
                    }else{
                        log1("查詢失敗");
                    }
                }
            });
        });
        //comment
        function log2(msg){
            console.log(msg);
        }
        $("#cm-submit").click(function() {
            var vid = $("#v_id").val();
            var text = $("#cm-text").val();
            if (!isLogin) {
                log2("您還為登錄");
                return;
            }
            if (/^\s*$/.test(text)) {
                log2("文本為空");
                return;
            }
            ajaxForm.action(this, {
                type: "post",
                url: "action/sendComment.php",
                data: {vid: vid, text: text},
                success: function (data) {
                    if (data.ok) {

                    } else if (data.msg) {
                        log2(data.msg);
                    } else {
                        log2("查詢失敗");
                    }
                }
            });
        });
        function loadComment(limit,offset){
            var vid=$("#v_id").val();
            ajaxForm.action(null,{
                type:"get",
                url:"action/loadComment.php",
                data:{vid:vid,limit:limit,offset:offset},
                success:function(data){
                    if(data.ok){
                        var data=data.data;
                        for(var i=0;i<data.length;i++){
                            var html=template("cm-li",{cm:data[i]});
                            $(".li-page").before(html);
                        }
                    }
                }
            });
        }
        $(function(){
            loadComment(10,0);
        });
        //reply
        function sendReply(btn){
            var cid=$(btn).parents(".re_sd").data("cid");
            var vid=$("#v_id").val();
            var text=$(btn).parents(".re_sd").find("input").val();
            if(!isLogin){
                log2("用戶未登錄");
            }
            if(/^\s*$/.test(text)){
                log2("無效文本");
            }
            ajaxForm.action(btn,{
                type:"post",
                url:"action/sendReply.php",
                data:{vid:vid,cid:cid,text:text},
                success:function(data){
                    if(data.ok){

                    }
                }
            });
        }
</script>
</body>
</html>