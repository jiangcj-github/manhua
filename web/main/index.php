<?php
require_once("../../php/global.php");
require_once("../../php/TimeUtil.php");
//數據庫連接
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//獲取Recently Updated
$result=$conn->query("select video.*,units.domain from video join units on video.unit=units.id order by time desc limit 19");
$vs1=$result->fetch_all(MYSQLI_ASSOC);
foreach($vs1 as $k=>$v){
    $vs1[$k]["time_str"]=time_tran($vs1[$k]["time"]);
    $vs1[$k]["poster"]=generateResourceUrl($vs1[$k]["id"].".png",$vs1[$k]["domain"]);
}
//獲取recommend Videos
$stmt=$conn->prepare("select video.*,units.domain from video join units on video.unit=units.id where video.time<? order by rand() limit 19");
$stmt->bind_param("s",end($vs1)["time"]);
$stmt->execute();
$vs2=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
foreach($vs2 as $k=>$v){
    $vs2[$k]["time_str"]=time_tran($vs2[$k]["time"]);
    $vs2[$k]["poster"]=generateResourceUrl($vs2[$k]["id"].".png",$vs2[$k]["domain"]);
}
?>
<html>
<head>
    <title>首页</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="css/vpre.css" rel="stylesheet"/>
    <link href="css/index.css" rel="stylesheet"/>
</head>
<body>
<?php include("../nav.php") ?>
<div class="page page-2col">
    <?php
    if($isLogin){
        //獲取recently Played
        $stmt=$conn->prepare("select video.*,units.domain from video join units on video.unit=units.id join user_played on video.id=user_played.vid where user_played.nick=? order by user_played.time limit 10");
        $stmt->bind_param("s",$_SESSION["login"]["nick"]);
        $stmt->execute();
        $vs3=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        foreach($vs3 as $k=>$v){
            $vs3[$k]["time_str"]=time_tran($vs3[$k]["time"]);
            $vs3[$k]["poster"]=generateResourceUrl($vs3[$k]["id"].".png",$vs3[$k]["domain"]);
        }
        if(count($vs3)>0){
        ?>
        <div class="sec">
            <div class="head">Recently played</div>
            <?php for($i=0;$i<count($vs3);$i++){
                if($i%5==0){ echo "<div class=\"row\">"; } ?>
                <a class="col" href="/web/play/play.php?id=<?php echo $vs3[$i]["id"] ?> target="_blank">
                    <div class="vpre">
                        <div class="label"><?php echo $vs3[$i]["duration"];?></div>
                        <img src="<?php echo $vs3[$i]["poster"];?>" class="col-img" />
                    </div>
                    <div class="info">
                        <div class="title"><?php echo $vs3[$i]["title"];?></div>
                        <div class="more">
                            <div class="time"><?php echo $vs3[$i]["time_str"];?></div>
                            <div class="count"><?php echo $vs3[$i]["playNum"];?><span>views</span></div>
                            <div class="like"><img src="../common/img/like_solid_f90.svg"><?php echo round(100*$vs3[$i]["up"]/($vs3[$i]["up"]+$vs3[$i]["down"])); ?>%</div>
                        </div>
                    </div>
                </a>
            <?php if($i%5==4){echo "</div>";}
            }
            if($i>0){
                $i--;
                if($i%5<4){echo "</div>";}
            }?>
        </div>
    <?php }} ?>
    <div class="sec">
        <div class="head">
            最近更新
        </div>
        <div class="ad1">
            400*560
        </div>
        <?php for($i=0;$i<count($vs1);$i++){
            if($i<9&&$i%3==0){ echo "<div class=\"row\">";}
            if($i>=9&&($i-9)%5==0){ echo "<div class=\"row\">";}?>
            <a class="col" href="/web/play/play.php?id=<?php echo $vs1[$i]["id"] ?> target="_blank">
                <div class="vpre">
                    <div class="label"><?php echo $vs1[$i]["duration"];?></div>
                    <img src="<?php echo $vs1[$i]["poster"];?>" class="col-img" />
                </div>
                <div class="info">
                    <div class="title"><?php echo $vs1[$i]["title"];?></div>
                    <div class="more">
                        <div class="time"><?php echo $vs1[$i]["time_str"];?></div>
                        <div class="count"><?php echo $vs1[$i]["playNum"];?><span>views</span></div>
                        <div class="like"><img src="../common/img/like_solid_f90.svg"><?php echo round(100*$vs1[$i]["up"]/($vs1[$i]["up"]+$vs1[$i]["down"])); ?>%</div>
                    </div>
                </div>
            </a>
            <?php if($i<9&&$i%3==2){echo "</div>";}
            if($i>=9&&($i-9)%5==4){echo "</div>"; }
        }
        if($i>0){
            $i--;
            if($i<9&&$i%3<2){ echo "</div>"; }
            if($i>=9&&($i-9)%5<4){ echo "</div>"; }
        }?>
    </div>
    <div class="sec">
        <div class="head">
            推荐视频
        </div>
        <div class="ad1">
            400*560
        </div>
        <?php for($i=0;$i<count($vs2);$i++){
            if($i<9&&$i%3==0){ echo "<div class=\"row\">";}
            if($i>=9&&($i-9)%5==0){ echo "<div class=\"row\">";}?>
            <a class="col" href="/web/play/play.php?id=<?php echo $vs2[$i]["id"] ?> target="_blank">
                <div class="vpre">
                    <div class="label"><?php echo $vs2[$i]["duration"];?></div>
                    <img src="<?php echo $vs2[$i]["poster"];?>" class="col-img" />
                </div>
                <div class="info">
                    <div class="title"><?php echo $vs2[$i]["title"];?></div>
                    <div class="more">
                        <div class="time"><?php echo $vs2[$i]["time_str"];?></div>
                        <div class="count"><?php echo $vs2[$i]["playNum"];?><span>views</span></div>
                        <div class="like"><img src="../common/img/like_solid_f90.svg"><?php echo round(100*$vs2[$i]["up"]/($vs2[$i]["up"]+$vs2[$i]["down"])); ?>%</div>
                    </div>
                </div>
            </a>
            <?php if($i<9&&$i%3==2){echo "</div>";}
            if($i>=9&&($i-9)%5==4){echo "</div>"; }
        }
        if($i>0){
            $i--;
            if($i<9&&$i%3<2){ echo "</div>"; }
            if($i>=9&&($i-9)%5<4){ echo "</div>"; }
        } ?>
    </div>
    <div class="sec">
        <div class="ad2">
            <div style="width:300px">300*250</div>
            <div style="width:300px">300*250</div>
            <div style="width:200px">200*250</div>
            <div style="width:250px">230*250</div>
        </div>
    </div>
</div>
<?php include("../footer.php") ?>
</body>
</html>