<?php
require_once("../php/global.php");

if(!isset($_REQUEST["id"])){
    die("404");
}
$id=$_REQUEST["id"];
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢video
$stmt=$conn->prepare("select a.id,a.filename,b.domain from video as a join units as b on a.unit=b.id where a.id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($id,$filename,$domain);
if(!$stmt->fetch()){
    die("404");
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>play</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="web/videojs/video-js.css" rel="stylesheet">
    <link href="web/videojs/video-js-custom.css" rel="stylesheet">
    <link href="web/css/page.css" rel="stylesheet">
    <link href="/common/honeySwitch/honeySwitch.css" rel="stylesheet">
    <script src="web/videojs/video.js"></script>
    <link href="web/css/play.css" rel="stylesheet">
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
            </div>
            <div class=" bg-div">
                <div class="bg-toggle">
                   <span class="switch-on" id="bg-toggle"></span>
                </div>
                <div class="input-group">
                    <input type="text" id="bg-text" placeholder="說點什麼吧，不超過15個字">
                    <button id="bg-submit" class="btn btn2">推送彈幕</button>
                </div>
            </div>
            <input type="hidden" id="v_id" value="<?php echo $id ?>">
            <div class="sec sm-div">
                <textarea id="cm-text" placeholder="說點什麼吧"></textarea>
                <button id="cm-submit" class="btn btn2 btn-lg">提交</button>
            </div>
            <div class="sec cm-div">
                <div class="li">
                    <div class="li_l">
                        <img class="head" src="">
                        <div class="nick">{{nick}}</div>
                    </div>
                    <div class="li_r">
                        <div class="r_c">
                            {{text}}
                        </div>
                        <div class="r_b">
                            <span class="label1">21樓</span>
                            <span>2012-12-01 23:23:33</span>
                            <span><a href="#">頂[0]</a></span>
                            <span><a href="#">踩[2]</a></span>
                            <span><a href="#">回復[4]</a></span>
                        </div>
                        <div class="r_re" data-cid="">
                            <div class="re_li">
                                <div class="re_li_l">
                                    <img src="">
                                </div>
                                <div class="re_li_r">
                                    <div class="re_li_r_c"><span class="nick">{{nick}}</span>{{reply}}</div>
                                    <div class="re_li_r_b">1999-22-32 33:43:12</div>
                                </div>
                            </div>
                            <div class="re_sd">
                                <input type="text" placeholder="說點什麼吧"><button class="btn btn2">回復</button>
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
                    <a href="#">5</a>
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

    <script src="/common/template-web.js"></script>
    <script src="/common/honeySwitch/honeySwitch.js"></script>
    <script id="cm-li" type="text/html">
        <div class="li">
            <div class="li_l">
                <img class="head" src="/common/headimg/rand_{{cm.nick.charCodeAt(0)%20}}.png">
                <div class="nick">{{cm.nick}}</div>
            </div>
            <div class="li_r">
                <div class="r_c">{{cm.text}}</div>
                <div class="r_b" data-cid="{{cm.id}}">
                    <span class="label1">{{cm.count}}樓</span>
                    <span>{{cm.time}}</span>
                    <span><a href="javascript:void(0);" onclick="onSendSup(this)">頂[<span field="suport">{{cm.suport}}</span>]</a></span>
                    <span><a href="javascript:void(0);" onclick="onSendObj(this)">踩[<span field="object">{{cm.object}}</span>]</a></span>
                    <span><a href="javascript:void(0);" onclick="onToggleRe(this)">回復[<span field="reply">{{cm.reply.length}}</span>]</a></span>
                </div>
                <div class="r_re" data-cid="{{cm.id}}">
                    <% for(var i=0;i<cm.reply.length;i++){ %>
                        <% if(i>=3){ %>
                            <div class="re_li" style="display:none">
                        <% }else{ %>
                            <div class="re_li">
                        <% } %>
                            <div class="re_li_l">
                                <img src="/common/headimg/rand_{{cm.reply[i].nick.charCodeAt(0)%20}}.png">
                            </div>
                            <div class="re_li_r">
                                <div class="re_li_r_c"><span class="nick">{{cm.reply[i].nick}}</span>{{cm.reply[i].text}}</div>
                                <div class="re_li_r_b">{{cm.reply[i].time}}</div>
                            </div>
                        </div>
                    <% } %>
                    <div class="re-insert" style="height:0"></div>
                    <% if(cm.reply.length>3){ %>
                        <div class="re_ctrl"><span more>隱藏({{cm.reply.length-3}})項</span>&nbsp;
                            <a href="javascript:void(0);" onclick="onMoreRe(this)" more>展開</a>
                            <a href="javascript:void(0);" onclick="onLessRe(this)" less style="display:none;">收起</a></div>
                    <% } %>
                    <div class="re_sd">
                        <input type="text" placeholder="說點什麼吧"><button class="btn btn2" onclick="onSendRe(this)">回復</button>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <script id="re-li" type="text/html">
        <div class="re_li">
            <div class="re_li_l">
                <img src="/common/headimg/rand_{{reply.nick.charCodeAt(0)%20}}.png">
            </div>
            <div class="re_li_r">
                <div class="re_li_r_c"><span class="nick">{{reply.nick}}</span>{{reply.text}}</div>
                <div class="re_li_r_b">{{reply.time}}</div>
            </div>
        </div>
    </script>
    <script id="cm-pg" type="text/html">
        <div class="li-page">
            <% if(curPage<=1){ %>
                <a href="javascript:void(0);" class="disabled">上一頁</a>
            <% }else{ %>
                <a href="javascript:void(0);" onclick="cmpage.load({{curPage-1}})">上一頁</a>
            <% } %>
            <% for(var i=0;i<5;i++){ %>
                <% if(curPage<=3){ %>
                    <% if(i+1>totalPage) continue; %>
                    <% if(i+1==curPage){ %>
                        <a href="javascript:void(0);" class="active">{{i+1}}</a>
                    <% }else{ %>
                        <a href="javascript:void(0);" onclick="cmpage.load({{i+1}})">{{i+1}}</a>
                    <% } %>
                <% }else if(curPage>=totalPage-2){ %>
                    <% if(totalPage-4+i<1) continue; %>
                    <% if(totalPage-4+i==curPage){ %>
                        <a href="javascript:void(0);" class="active">{{totalPage-4+i}}</a>
                    <% }else{ %>
                        <a href="javascript:void(0);" onclick="cmpage.load({{totalPage-4+i}})">{{totalPage-4+i}}</a>
                    <% } %>
                <% }else{ %>
                    <% if(curPage-2+i==curPage){ %>
                        <a href="javascript:void(0);" class="active">{{curPage-2+i}}</a>
                    <% }else{ %>
                        <a href="javascript:void(0);" onclick="cmpage.load({{curPage-2+i}})">{{curPage-2+i}}</a>
                    <% } %>
                <% } %>
            <% } %>
            <% if(curPage>=totalPage){ %>
                <a href="javascript:void(0);" class="disabled">下一頁</a>
            <% }else{ %>
                <a href="javascript:void(0);" onclick="cmpage.load({{curPage+1}})">下一頁</a>
            <% } %>
        </div>
    </script>
    <script src="web/js/play.js"></script>
</body>
</html>