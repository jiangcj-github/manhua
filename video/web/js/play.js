var vid=$("#v_id").val();
var bgSpeed=3;
var player = videojs("v1",{}, function(){
    this.on("durationchange",function(){
        var duration=this.duration();
        ajaxForm.action(null,{
            url:"action/loadBarrage.php",
            data:{vid:vid},
            success:function(data){
                if(data.ok){
                    var html=$("<div class='barg-div'></div>");
                    var path=$("<div class='path'></div>").css("width",duration*bgSpeed*16+"px");
                    html.append(path.clone());
                    html.append(path.clone());
                    html.append(path.clone());
                    html.append(path.clone());
                    html.append(path.clone());
                    for(var i=0;i<data.data.length;i++){
                        var span=$("<span></span>").css("left",data.data[i].pos*bgSpeed*16+"px").html(data.data[i].msg);
                        html.find(".path").eq(i%5).append(span);
                    }
                    $(".video-js").append(html);
                }
            }
        });
    });
    this.on("timeupdate",function(){
        $(".barg-div") && $(".barg-div>.path").css("left",-this.currentTime()*bgSpeed*16+"px");
    });
});
//barrage
var barrage={};
barrage.sendBtn=$("#bg-submit")[0];
barrage.sendInput=$("#bg-text")[0];
barrage.init=function(){
    var _this=this;
    switchEvent("#bg-toggle",
        function(){
            $(".barg-div").show();
        },function(){
            $(".barg-div").hide();
        });
    $(_this.sendBtn).click(function(){_this.send()});
};
barrage.log=function(msg){
    alert(msg);
};
barrage.send=function(){
    var _this=this;
    var msg=$(_this.sendInput).val();
    var pos=player.currentTime();
    var duration=player.duration();
    if(!isLogin){
        _this.log("您還未登錄");
        return;
    }
    if(pos<=0||pos>=duration){
        _this.log("無效時間");
        return;
    }
    if(/^\s*$/.test(msg)){
        _this.log("無效文本");
        return;
    }
    if(msg.length<=0||msg.length>15){
        _this.log("文本超過字符數限制");
        return;
    }
    ajaxForm.action(_this.sendBtn,{
        type:"post",
        url:"action/sendBarrage.php",
        data:{vid:vid,msg:msg,pos:pos,duration:duration},
        success:function(data){
            if(data.ok){
                _this.sendOk(msg,pos);
            }else if(data.msg){
                _this.log(data.msg);
            }else{
                _this.log("查詢失敗");
            }
        }
    });
};
barrage.sendOk=function(msg,pos){
    var _this=this;
    $(_this.sendBtn).attr("disabled",true).text(60);
    $(_this.sendInput).val(null);
    setTimeout(bgTimeout,1000,60);
    var span=$("<span style='color:blue'></span>").css("left",pos*bgSpeed*16+"px").html(msg);
    var i = Math.floor(Math.random()*5);
    $(".barg-div").find(".path").eq(i%5).append(span);
};
var bgTimeout=function(sec){
    if(sec==0){
        $(barrage.sendBtn).attr("disabled",false).text("推送彈幕");
    }else{
        $(barrage.sendBtn).attr("disabled",true).text(sec);
        setTimeout(bgTimeout,1000,sec-1);
    }
};
//init
$(function(){
    barrage.init();
    comment.init();
});
//comment
var comment={};
comment.sendBtn=$("#cm-submit")[0];
comment.sendInput=$("#cm-text")[0];
comment.log=function(msg){
    alert(msg);
};
comment.init=function(){
    var _this=this;
    $(_this.sendBtn).click(function(){_this.send();});
    _this.load(10,0);
};
comment.send=function(){
    var _this=this;
    var text = $(_this.sendInput).val();
    if (!isLogin) {
        _this.log("您還為登錄");
        return;
    }
    if (/^\s*$/.test(text)) {
        _this.log("文本為空");
        return;
    }
    ajaxForm.action(_this.sendBtn,{
        type: "post",
        url: "action/sendComment.php",
        data: {vid: vid, text: text},
        success: function (data) {
            if (data.ok) {

            } else if (data.msg) {
                _this.log(data.msg);
            } else {
                _this.log("查詢失敗");
            }
        }
    });
};
comment.load=function(limit,offset){
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
};





//reply
function sendReply(btn){
    var cid=$(btn).parents(".re_sd").data("cid");
    var text=$(btn).parents(".re_sd").find("input").val();
    if(!isLogin){
        _this.log("用戶未登錄");
    }
    if(/^\s*$/.test(text)){
        _this.log("無效文本");
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