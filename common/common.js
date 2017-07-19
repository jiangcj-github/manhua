//----------------------------------------------------------------------------------------------------------------------
var ajaxForm={};
ajaxForm.target=null;
ajaxForm.before=function(){
    this.target && $(this.target).attr("disabled",true);
};
ajaxForm.complete=function(){
    this.target && $(this.target).attr("disabled",false);
};
ajaxForm.action=function(target,option){
    this.target=target;
    this.before();
    var _this=this;
    $.ajax({
        type:option.type,
        url: option.url,
        data:option.data,
        timeout:10000,
        dataType:option.dataType||"json",
        contentType:option.contentType||"application/x-www-form-urlencoded",
        success:function(data){
            _this.complete();
            option.success&&option.success(data);
        },
        error:function(xhr,text,exception){
            _this.complete();
            option.error&&option.error(text);
        }
    });
};
//
//----------------------------------------------------------------------------------------------------------------------
//cookie operation
function setCookie(name,value,days) {
    var Days = days || 1;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toUTCString() + ";path=/"
}
function getCookie(name) {
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}
function delCookie(name){
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval){
        document.cookie= name + "="+cval+";expires="+exp.toUTCString() + ";path=/";
    }
}
function matchCookie(preg){
    var re = new RegExp(preg,"g");
    var arr = document.cookie.match(re);
    return arr?arr.length:0;
}
//_blank可能存在的問題
$(function(){
   $("a.outer").attr("rel","noopener noreferrer");
});