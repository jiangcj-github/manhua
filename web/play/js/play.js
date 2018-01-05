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

var barrage={};
barrage.widgets={
    bargDiv:$(".barg-div"),
    sendInput:$("#bg-text"),
    sendBtn:$("#bg-submit")
};
barrage.init=function(){
    var _this=this;
    switchEvent("#bg-toggle",
        function(){
            _this.widgets.bargDiv.show();
        },function(){
            _this.widgets.bargDiv.hide();
        });
    _this.widgets.sendBtn.click(function(){
        _this.send()
    });
};
barrage.log=function(msg){
    alert(msg);
};
barrage.send=function(){
    var _this=this;
    var msg=_this.widgets.sendInput.val();
    var pos=player.currentTime();
    var duration=player.duration();
    if(!isLogin){
        _this.log("未登录");
        return;
    }
    if(pos<=0||pos>=duration){
        _this.log("无效时间");
        return;
    }
    if(/^\s*$/.test(msg)){
        _this.log("无效文本");
        return;
    }
    if(msg.length<=0||msg.length>15){
        _this.log("文本太长");
        return;
    }
    ajaxForm.action(_this.widgets.sendBtn,{
        type:"post",
        url:"/action/sendBarrage.php",
        data:{vid:vid,msg:msg,pos:pos,duration:duration},
        success:function(data){
            if(data.ok){
                _this.sendOk(msg,pos);
            }else if(data.msg){
                _this.log(data.msg);
            }
        }
    });
};
barrage.sendOk=function(msg,pos){
    var _this=this;
    _this.widgets.sendInput.val(null);
    setTimeout(bgTimeout,0,60);
    var span=$("<span style='color:blue'></span>").css("left",pos*bgSpeed*16+"px").html(msg);
    var i = Math.floor(Math.random()*5);
    _this.widgets.bargDiv.find(".path").eq(i%5).append(span);
};
var bgTimeout=function(sec){
    if(sec==0){
        $(barrage.widgets.sendBtn).attr("disabled",false).text("发送弹幕");
    }else{
        $(barrage.widgets.sendBtn).attr("disabled",true).text(sec);
        setTimeout(bgTimeout,1000,sec-1);
    }
};

//init
$(function(){
    barrage.init();
    comment.init();
    infoDiv.init();
    $(document).bind("contextmenu", function(){return false;});
});

/*
 * comment Manager
 * ------------------------------------------------------------------------------------------------------------------
 */
var comment={};
comment.widgets={
    sendBtn:$("#cm-submit"),
    sendInput:$("#cm-text"),
    cmDiv:$(".cm-div")
};
comment.log=function(msg){
    alert(msg);
};
comment.init=function(){
    var _this=this;
    _this.widgets.sendBtn.click(function(){
        _this.send();
    });
    _this.initPage();
};
comment.send=function(){
    var _this=this;
    var text = _this.widgets.sendInput.val();
    if (!isLogin) {
        _this.log("未登录");
        return;
    }
    if (/^\s*$/.test(text)) {
        _this.log("文本为空");
        return;
    }
    ajaxForm.action(_this.widgets.sendBtn,{
        type: "post",
        url: "/action/sendComment.php",
        data: {vid: vid, text: text},
        success: function (data) {
            if (data.ok) {
                _this.sendOk();
            } else if (data.msg) {
                _this.log(data.msg);
            }
        }
    });
};
comment.sendOk=function(){
    var _this=this;
    _this.widgets.sendInput.val(null);
    setTimeout(cmTimeout,0,300);
    _this.initPage();
};
comment.getReplyBtn=function(){
    return $(".re_sd").find("button");
};
comment.limit=10;
comment.curPage=0;
comment.totalPage=0;
comment.buffer=[];
comment.load=function(page){
    var _this=this;
    if(page<1||page>_this.totalPage) return;
    _this.curPage=page;
    if(_this.buffer[_this.curPage]){
        _this.loadOk();
        return;
    }
    ajaxForm.action(null,{
        type:"get",
        url:"/action/loadComment.php",
        data:{vid:vid,limit:_this.limit,offset:(_this.curPage-1)*_this.limit},
        success:function(data){
            if(data.ok){
                _this.buffer[_this.curPage]=data.data;
                _this.loadOk();
            }
        }
    });
};
comment.loadOk=function(){
    var _this=this;
    _this.widgets.cmDiv.empty();
    _this.buffer[_this.curPage].forEach(function(v){
        var html=template("cm-li",{cm:v});
        _this.widgets.cmDiv.append(html);
    });
    var html=template("cm-pg",{curPage:_this.curPage,totalPage:_this.totalPage});
    _this.widgets.cmDiv.append(html);
};
comment.initPage=function(){
    var _this=this;
    _this.buffer=[];
    ajaxForm.action(null,{
        type:"post",
        url:"/action/loadCommentInfo.php",
        data:{vid:vid},
        success:function(data) {
            if(data.ok){
                _this.totalPage=Math.ceil(data.data.count/_this.limit);
                _this.load(1);
            }
        }
    })
};

var cmTimeout=function(sec){
    if(sec==0){
        $(comment.widgets.sendBtn).attr("disabled",false).text("提交");
    }else{
        $(comment.widgets.sendBtn).attr("disabled",true).text(sec);
        setTimeout(cmTimeout,1000,sec-1);
    }
};


function Reply(div){
    this.html=div;
}
Reply.prototype.getCid=function(){
    return $(this.html).data("cid");
};
Reply.prototype.sendBtn=function(){
    return $(this.html).find(".re_sd button");
};
Reply.prototype.getResd=function(){
    return $(this.html).find(".re_sd");
};
Reply.prototype.getReplyCountSpan=function(){
    return $(this.html).parents(".li").find(".reply");
};
Reply.prototype.sendInput=function(){
    return $(this.html).find(".re_sd input");
};
Reply.prototype.send=function(){
    var _this=this;
    var text=_this.sendInput().val();
    if(!isLogin){
        comment.log("未登录");
        return;
    }
    if(/^\s*$/.test(text)){
        comment.log("无效文本");
        return;
    }
    ajaxForm.action(_this.sendBtn(),{
        type:"post",
        url:"/action/sendReply.php",
        data:{vid:vid,cid:_this.getCid(),text:text},
        success:function(data){
            if(data.ok){
                _this.sendOk(data.data);
            }else if(data.msg){
                comment.log(data.msg);
            }
        }
    });
};
Reply.prototype.sendOk=function(data){
    $(this.sendInput()).val(null);
    setTimeout(reTimeout,0,120);
    //append
    var html=template("re-li",{reply:data});
    $(this.html).find(".re-insert").before(html);
    var span=this.getReplyCountSpan();
    span.text(parseInt(span.text())+1);
};
Reply.prototype.toggle=function(){
    $(this.html).toggleClass("hide");
};
Reply.prototype.toggleResd=function(){
    var resd=this.getResd();
    resd.toggleClass("show");
};
Reply.prototype.moreRe=function(){
    $(this.html).find(".re_li").show();
    $(this.html).find(".re_ctrl .more").hide();
    $(this.html).find(".re_ctrl .less").show();
};
Reply.prototype.lessRe=function(){
    $(this.html).find(".re_li:gt(2)").hide();
    $(this.html).find(".re_ctrl .more").show();
    $(this.html).find(".re_ctrl .less").hide();
};
var reTimeout=function(sec){
    if(sec==0){
        $(comment.getReplyBtn()).attr("disabled",false).text("回复");
    }else{
        $(comment.getReplyBtn()).attr("disabled",true).text(sec);
        setTimeout(reTimeout,1000,sec-1);
    }
};
//element event
function onSendRe(btn){
    var div=$(btn).parents(".r_re");
    var reply=new Reply(div);
    reply.send();
}
function onToggleRe(a){
    var div=$(a).parents(".li").find(".r_re");
    var reply=new Reply(div);
    reply.toggle();
}
function onMoreRe(a){
    var div=$(a).parents(".li").find(".r_re");
    var reply=new Reply(div);
    reply.moreRe();
}
function onLessRe(a){
    var div=$(a).parents(".li").find(".r_re");
    var reply=new Reply(div);
    reply.lessRe();
}
function onToggleResd(a){
    var div=$(a).parents(".li").find(".r_re");
    var reply=new Reply(div);
    reply.toggleResd();
}

/**
 * Suport Manager
 */
 function Suport(div){
    this.html=div;
}
Suport.prototype.getCid=function(){
    return $(this.html).data("cid");
};
Suport.prototype.sendSup=function(a){
    var _this=this;
    var cid=_this.getCid();
    if(!isLogin){
        comment.log("未登录");
        return;
    }
    if(getCookie("vsup10_"+vid+"#"+cid)){
        comment.log("已经顶过来，24小时后再试");
        return;
    }
    if(matchCookie("vsup10_")>=10){
        comment.log("操作已达上限，24小时后再试");
        return;
    }
    ajaxForm.action(a,{
        type:"post",
        url:"/action/sendSuport.php",
        data:{vid:vid,cid:cid},
        success:function(data){
            if(data.ok){
                _this.sendSupOk(vid,cid);
            }else if(data.msg){
                comment.log(data.msg);
            }
        }
    });
};
Suport.prototype.sendSupOk=function(vid,cid){
    var span=$(this.html).find(".suport");
    span.text(parseInt(span.text())+1);
    setCookie("vsup10_"+vid+"#"+cid,1,1);
};
Suport.prototype.sendObj=function(a){
    var _this=this;
    var cid=_this.getCid();
    if(!isLogin){
        comment.log("未登录");
        return;
    }
    if(getCookie("vobj10_"+vid+"#"+cid)){
        comment.log("已经踩过来，24小时后再试");
        return;
    }
    if(matchCookie("vobj10_")>=10){
        comment.log("操作已达上限，24小时后再试");
        return;
    }
    ajaxForm.action(a,{
        type:"post",
        url:"/action/sendObject.php",
        data:{vid:vid,cid:cid},
        success:function(data){
            if(data.ok){
                _this.sendObjOk(vid,cid);
            }else if(data.msg){
                comment.log(data.msg);
            }
        }
    });
};
Suport.prototype.sendObjOk=function(vid,cid){
    var span=$(this.html).find(".object");
    span.text(parseInt(span.text())+1);
    setCookie("vobj10_"+vid+"#"+cid,1,1);
};
//
function onSendObj(a){
    var div=$(a).parents(".r_b");
    var suport=new Suport(div);
    suport.sendObj(a);
}
function onSendSup(a){
    var div=$(a).parents(".r_b");
    var suport=new Suport(div);
    suport.sendSup(a);
}

/**
 * info-div Manager
 */
var infoDiv={};
infoDiv.widgets={
    shareBtn:$("#info_share"),
    feedbackBtn:$("#info_feedback"),
    sharePP:$(".popup.share"),
    feedbackPP:$(".popup.feedback")
};
infoDiv.init=function(){
    var _this=this;
    _this.widgets.shareBtn.click(function(){_this.toggleShare();});
    _this.widgets.feedbackBtn.click(function(){_this.toggleFeedback();});
    sharePP.init();
    vote.init();
    feedBackPP.init();
};
infoDiv.toggleShare=function(){
    var _this=this;
    _this.widgets.feedbackPP.hide();
    _this.widgets.sharePP.toggle();
};
infoDiv.toggleFeedback=function(){
    var _this=this;
    _this.widgets.sharePP.hide();
    _this.widgets.feedbackPP.toggle();
};

/**
 * vote Manager
 */
var vote={};
vote.widgets={
    upBtn:$(".vote-btn.up"),
    downBtn:$(".vote-btn.down"),
    wrapDiv:$(".vote-wrap"),
    voteText:$("#voteText"),
    voteBar:$("#voteBar")
};
vote.init=function(){
    var _this=this;
    _this.widgets.upBtn.click(function(){
        _this.send(1);
    });
    _this.widgets.downBtn.click(function(){
        _this.send(0);
    });
};
vote.log=function(msg){
    alert(msg);
};
vote.send=function(v){
    var _this=this;
    if(v!==0&&v!==1) return;
    if(!isLogin){
        _this.log("未登录");
        return;
    }
    if(getCookie("vvot10_"+vid)){
        _this.log("已经投过票了，24小时后再试");
        return;
    }
    if(matchCookie("vvot10_")>=10){
        _this.log("操作已达上限，24小时后再试");
        return;
    }
    ajaxForm.action(null,{
        type:"post",
        url:"/action/sendVideoVote.php",
        data:{vid:vid,vote:v},
        success:function(data){
            if(data.ok){
                _this.sendOk(v);
            }else if(data.msg){
                _this.log(data.msg);
            }
        }
    });
};
vote.sendOk=function(v){
    var _this=this;
    var ups=parseInt(_this.widgets.wrapDiv.data("up"));
    var downs=parseInt(_this.widgets.wrapDiv.data("down"));
    var newRate=0;
    if(v==1){
        _this.widgets.wrapDiv.data("up",ups+1);
        newRate=Math.round(100*(ups+1)/(ups+downs+1));
    }else{
        _this.widgets.wrapDiv.data("down",downs+1);
        newRate=Math.round(100*ups/(ups+downs+1));
    }
    _this.widgets.voteText.text(newRate+"%");
    _this.widgets.voteBar.css("width",newRate+"%");
    setCookie("vvot10_"+vid,1,1);
};

/**
 * sharePP Manager
 */
var sharePP={};
sharePP.widgets={
    inputEm:$("#sp-em"),
    inputW:$("#sp-w"),
    inputH:$("#sp-h")
};
sharePP.wChange=function(){
    var _this=this;
    var w=parseInt(_this.widgets.inputW.val());
    if(isNaN(w)||w<0){
        w=0;
    }
    var oval=_this.widgets.inputEm.val();
    oval=oval.replace(/width='[0-9]*'/,"width='"+w+"'");
    _this.widgets.inputEm.val(oval);
};
sharePP.hChange=function(){
    var _this=this;
    var h=parseInt(_this.widgets.inputH.val());
    if(isNaN(h)||h<0){
        h=0;
    }
    var oval=_this.widgets.inputEm.val();
    oval=oval.replace(/height='[0-9]*'/,"height='"+h+"'");
    _this.widgets.inputEm.val(oval);
};
sharePP.init=function(){};

/**
 * feedbackPP Manager
 */
var feedBackPP={};
feedBackPP.widgets={
    msgRadio:$(".popup.feedback").find("input[name=fp_msg]"),
    msgInput:$("#fp_msg_input"),
    describInput:$("#fp_describ"),
    emailInput:$("#fp_email"),
    submitBtn:$("#fp_submit")
};
feedBackPP.init=function(){
    var _this=this;
    _this.widgets.msgRadio.change(function(){_this.radioChange();});
    _this.widgets.submitBtn.click(function(){_this.send();})
};
feedBackPP.log=function(msg){
    alert(msg);
};
feedBackPP.radioChange=function(){
    var _this=this;
    var msg=_this.widgets.msgRadio.filter(":checked").val();
    if(!msg){
        _this.widgets.msgInput.show();
    }else{
        _this.widgets.msgInput.hide();
    }
};
feedBackPP.send=function(){
    var _this=this;
    var msg=_this.widgets.msgRadio.filter(":checked").val();
    if(!msg){
        msg=_this.widgets.msgInput.val();
    }
    var describ=_this.widgets.describInput.val();
    var email=_this.widgets.emailInput.val();
    if(!isLogin){
        _this.log("未登录");
        return;
    }
    if(/^\s*$/.test(msg)){
        _this.log("无效反馈信息");
        return;
    }
    if(!/^[0-9A-Za-z-_.]+@[0-9A-Za-z-_.]+$/.test(email)){
        _this.log("无效Email");
        return;
    }
    ajaxForm.action(_this.widgets.submitBtn,{
        type:"post",
        url:"/action/sendFeedback.php",
        data:{vid:vid,msg:msg,describ:describ,email:email},
        success:function(data){
            if(data.ok){
                _this.sendOk();
            }else if(data.msg){
                _this.log(data.msg);
            }
        }
    });
};
feedBackPP.sendOk=function(){
    setTimeout(feedTimeout,0,600);
};
var feedTimeout=function(sec){
    if(sec==0){
        $(feedBackPP.widgets.submitBtn).attr("disabled",false).text("提交");
    }else{
        $(feedBackPP.widgets.submitBtn).attr("disabled",true).text(sec);
        setTimeout(feedTimeout,1000,sec-1);
    }
};