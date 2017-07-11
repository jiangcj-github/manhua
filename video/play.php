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
    <script src="web/js/play.js"></script>
</body>
</html>