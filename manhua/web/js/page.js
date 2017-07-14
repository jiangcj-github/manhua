//comment
var cmt={};
cmt.sendBtn=$("#cm-send");
cmt.sendInput=$("#text");
cmt.pDiv=$("#cm");
cmt.loadBtn=$("#cm-load");
cmt.cLimit=10;
cmt.getItemLength=function(){
  return this.pDiv.find("li.cm-ci").length;
};
cmt.init=function(){
    var _this=this;
    _this.sendBtn.click(function(){_this.send();});
    _this.loadBtn.click(function(){_this.load(_this.getItemLength());});
    _this.load(0);
};
cmt.log=function(msg){
    alert(msg);
};
cmt.sendOk=function(data){
    var li=template("tpl-li",{comm:data});
    this.pDiv.prepend(li);
    this.sendInput.val(null);
    setTimeout(smTimeout,0,120);
};
cmt.send=function(){
    var _this=this;
    var text=_this.sendInput.val();
    if(text==null||/^\s*$/.test(text)){
        _this.log("無效文本");
        return;
    }
    ajaxForm.action(_this.sendBtn,{
        type:"post",
        url:"action/sendComment.php",
        data:{mid:mid,chapter:chapter,text:text},
        success:function(data){
            if(data.ok){
                _this.sendOk(data.data);
            }else if(data.msg){
                _this.log(data.msg);
            }else{
                _this.log("查詢失敗");
            }
        }
    });
};
cmt.load=function(offset){
    var _this=this;
    ajaxForm.action(_this.loadBtn,{
        url:"action/loadComment.php",
        data:{mid:mid,chapter:chapter,offset:offset},
        success:function(data){
            if(data.ok){
                _this.loadOk(data.data);
            }else if(data.msg){
                _this.log(data.msg);
            }else{
                _this.log("查詢失敗");
            }
        }
    });
};
cmt.loadOk=function(data){
    var _this=this;
    for(var i=0;i<data.length;i++){
        var li=template("tpl-li",{comm:data[i]});
        _this.pDiv.append(li);
    }
    if(data.length<_this.cLimit){
        _this.loadBtn.unbind();
        _this.loadBtn.text("已加载全部");
    }
};
var smTimeout=function(sec){
    if(sec==0){
        cmt.sendBtn.attr("disabled",false).text("提交");
    }else{
        cmt.sendBtn.attr("disabled",true).text(sec);
        setTimeout(smTimeout,1000,sec-1);
    }
};

$(function(){
    cmt.init();
    mhPage.init();
});

//mh_page
var mhPage={};
mhPage.select=$(".ct-page").find("select");
mhPage.beforeBtn=$("#bfBtn");
mhPage.afterBtn=$("#afBtn");
mhPage.mh=$("#mh");
mhPage.mh_buffer=$("#mh_buffer");
mhPage.curPage=1;
mhPage.totalPage=parseInt($("#mh_buffer").data("total"));
mhPage.init=function(){
    var _this=this;
    _this.go(1);
    _this.beforeBtn.click(function(){_this.before();});
    _this.afterBtn.click(function(){_this.after();});
    _this.select.change(function(){_this.go(parseInt($(this).val()));})
};
mhPage.go=function(page){
    var _this=this;
    if(page<1 || page>_this.totalPage) return;
    _this.curPage=page;
    _this.mh_buffer.append(_this.mh.find("img"));
    var img=_this.mh_buffer.find("img[p="+_this.curPage+"]");
    if(!img.prop("src")){
        img.prop("src",function(){
            return $(this).data("src");
        });
    }
    _this.mh.append(img);
    _this.updateHtml();
};
mhPage.updateHtml=function(){
    var _this=this;
    if(_this.curPage<=1){
        _this.beforeBtn.prop("disabled",true);
        _this.beforeBtn.text("首頁");
    }else{
        _this.beforeBtn.prop("disabled",false);
        _this.beforeBtn.text("上一頁");
    }
    if(_this.curPage>=_this.totalPage){
        _this.afterBtn.prop("disabled",true);
        _this.afterBtn.text("尾頁");
    }else{
        _this.afterBtn.prop("disabled",false);
        _this.afterBtn.text("下一頁");
    }
    _this.select.val(_this.curPage);
};
mhPage.before=function(){
    var _this=this;
    if(_this.curPage<=1) return;
    _this.curPage--;
    _this.mh_buffer.append(_this.mh.find("img"));
    var img=_this.mh_buffer.find("img[p="+_this.curPage+"]");
    if(!img.prop("src")){
        img.prop("src",function(){
           return $(this).data("src");
        });
    }
    _this.mh.append(img);
    _this.updateHtml();
};
mhPage.after=function(){
    var _this=this;
    if(_this.curPage>=_this.totalPage) return;
    _this.curPage++;
    _this.mh_buffer.append(_this.mh.find("img"));
    var img=_this.mh_buffer.find("img[p="+_this.curPage+"]");
    if(!img.prop("src")){
        img.prop("src",function(){
            return $(this).data("src");
        });
    }
    _this.mh.append(img);
    _this.updateHtml();
};
function onBeforePage(){
    mhPage.before();
}
function onAfterPage() {
    mhPage.after();
}