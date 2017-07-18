<?php
require_once("../php/global.php");

if(!isset($_REQUEST["id"])){
    die("404");
}
$id=$_REQUEST["id"];
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查詢video
$stmt=$conn->prepare("select a.id,a.filename,b.domain,a.up,a.down,a.playNum from video as a join units as b on a.unit=b.id where a.id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($id,$filename,$domain,$up,$down,$playNum);
if(!$stmt->fetch()){
    die("404");
}
$stmt->close();
//寫入播放次數
$stmt=$conn->prepare("update video set playNum=playNum+1 where id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
//計算評論條數
$stmt=$conn->prepare("select count(id) as count from video_comment where vid=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($cmt_count);
$stmt->fetch();
$stmt->close();
//計算vote
if($up+$down==0){
    $vote_rate=0;
}else{
    $vote_rate=round(100*$up/($up+$down));
}
//獲取randVideo
$stmt=$conn->prepare("select a.id,a.filename,a.duration,b.domain from video as a join units as b on a.unit=b.id where a.id!=? order by rand() limit 10");
$stmt->bind_param("i",$id);
$stmt->execute();
$result=$stmt->get_result();
$randVs=$result->fetch_all(MYSQLI_ASSOC);
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
            <div class="bg-div">
                <div class="bg-toggle">
                   <span class="switch-on" id="bg-toggle"></span>
                </div>
                <div class="input-group">
                    <input type="text" id="bg-text" placeholder="說點什麼吧，不超過15個字">
                    <button id="bg-submit" class="btn btn2">推送彈幕</button>
                </div>
            </div>
            <div class="sec info-div">
                <div class="row">
                    <div class="vote-wrap" data-up="<?php echo $up ?>" data-down="<?php echo $down ?>">
                        <a href="javascript:void(0);" class="vote-btn up"></a>
                        <div class="vote-show">
                            <div class="stext">好評(<span id="voteText"><?php echo $vote_rate ?>%</span>)</div>
                            <div class="slider-wrap">
                                <div class="up" id="voteBar" style="width:<?php echo $vote_rate ?>%"></div>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="vote-btn down"></a>
                    </div>
                    <span>播放<span style="color:#ddd;"><?php echo $playNum ?></span>次</span>
                    <span>評論<span style="color:#ddd;"><?php echo $cmt_count ?></span>條</span>
                    <div class="right">
                        <a href="javascript:void(0);" class="btn btn2" id="info_share"><img src="web/img/share.svg">分享</a>
                        <a href="javascript:void(0);" class="btn btn2" id="info_feedback"><img src="web/img/feedback.svg">反饋</a>
                        <a href="#cm-text" class="btn btn2"><img src="web/img/chat.svg">評論</a>
                        <a href="download.php?vid=<?php echo $id ?>" target="_blank" class="btn btn2"><img src="web/img/download.svg">下載</a>
                    </div>
                </div>
                <div class="popup share">
                    <div class="label">Embed代码</div>
                    <input type="text" id="sp-em" value="<iframe width='640' height='360' src='http://localhost/video/play.php?id=1' frameborder='0' allowfullscreen></iframe>">
                    <div class="sep"></div>
                    <div class="label">寬度和高度</div>
                    <div class="pprow">
                        <input type="text" id="sp-w" value="640" oninput="sharePP.wChange();" onchange="sharePP.wChange();"><span>&times;</span>
                        <input id="sp-h" type="text" value="360" oninput="sharePP.hChange();" onchange="sharePP.hChange();">
                    </div>
                </div>
                <div class="popup feedback">
                    <div class="label">反饋信息(必需)</div>
                    <div class="pprow">
                        <label><input type="radio" name="fp_msg" value="內容令人反感。">內容令我反感。</label>
                        <label><input type="radio" name="fp_msg" value="非法偷拍或者內容侵犯我的人身權利。">內容侵犯我的人身權利。</label>
                        <label><input type="radio" name="fp_msg" value="含有性暴力，兒童色情等內容。">含有性暴力，兒童色情等內容。</label>
                        <label><input type="radio" name="fp_msg" value="內容侵犯版權。">內容侵犯我的版權。</label>
                        <label><input type="radio" name="fp_msg" value="">其他</label>
                    </div>
                    <input type="text" id="fp_msg_input" style="display:none;">
                    <div class="sep"></div>
                    <div class="label">詳細說明(可選)</div>
                    <textarea id="fp_describ"></textarea>
                    <div class="sep"></div>
                    <div class="label">Email(可選)</div>
                    <input type="text" id="fp_email">
                    <div class="sep"></div>
                    <div class="pprow">
                        <a href="javascript:void(0)" class="btn btn2 btn-lg" id="fp_submit">提交</a>
                    </div>
                </div>
            </div>
            <div class="sec ad-div">
                <a href="#"><img src="" alt="300*200" style="width:300px;height:200px"></a>
                <a href="#"><img src="" alt="300*200" style="width:300px;height:200px"></a>
                <a href="#"><img src="" alt="200*200" style="width:200px;height:200px"></a>
            </div>
            <div class="sec sm-div">
                <textarea id="cm-text" placeholder="說點什麼吧"></textarea>
                <button id="cm-submit" class="btn btn2 btn-lg">提交</button>
            </div>
            <div class="sec cm-div"></div>
        </div>

        <div class="right">
            <div class="pane">
                <div class="ad-pane">
                    <a href="#"><img src="" alt="200*300" style="width:200px;height:300px;"></a>
                </div>
            </div>
            <div class="pane">
                <h3>相關內容</h3>
                <?php
                    for($i=0;$i<count($randVs);$i++){
                        $poster=substr($randVs[$i]["filename"],0,strpos($randVs[$i]["filename"],".")).".png";
                        $ps=generateResourceUrl($poster,$randVs[$i]["domain"]);
                ?>
                    <div class="item-v vpre">
                        <div class="label"><?php echo $randVs[$i]["duration"] ?></div>
                        <a href="play.php?id=<?php echo $randVs[$i]["id"] ?>" target="_blank">
                            <img src="<?php echo $ps ?>" onerror="this.src='web/1.png';">
                        </a>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>

    <script src="/common/template-web.js"></script>
    <script src="/common/honeySwitch/honeySwitch.js"></script>
    <script id="cm-li" type="text/html">
        <div class="li">
            <div class="li_l">
                <img class="head" src="/common/headimg/head.gif">
                <div class="nick">{{cm.nick}}</div>
            </div>
            <div class="li_r">
                <div class="r_c">{{cm.text}}</div>
                <div class="r_b" data-cid="{{cm.id}}">
                    <span class="label1">{{cm.count}}樓</span>
                    <span>{{cm.time}}</span>
                    <span><a href="javascript:void(0);" onclick="onSendSup(this)"><img src="web/img/like.svg">(<span field="suport">{{cm.suport}}</span>)</a></span>
                    <span><a href="javascript:void(0);" onclick="onSendObj(this)"><img src="web/img/unlike.svg">(<span field="object">{{cm.object}}</span>)</a></span>
                    <span><a href="javascript:void(0);" onclick="onToggleRe(this)"><img src="web/img/reply.svg">(<span field="reply">{{cm.reply.length}}</span>)</a></span>
                </div>
                <div class="r_re" data-cid="{{cm.id}}">
                    <% for(var i=0;i<cm.reply.length;i++){ %>
                        <% if(i>=3){ %>
                            <div class="re_li" style="display:none">
                        <% }else{ %>
                            <div class="re_li">
                        <% } %>
                            <div class="re_li_l">
                                <img src="/common/headimg/head.gif">
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
                <img src="/common/headimg/head.gif">
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
    <script>var vid=<?php echo $id ?>;</script>
</body>
</html>