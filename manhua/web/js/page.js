//
$(function(){
    //lazyload
    $("img.lazy").lazyload({effect: "fadeIn"});
    //加载评论信息
    moreComment(0);
});

//加载更多评论信息
function moreComment(offset){
    $.ajax({
        url:"action/loadComment.php",
        data:{mid:mid,chapter:chapter,offset:offset},
        dataType:"json",
        success:function(data){
            for(var i=0;i<data.length;i++){
                var li=template("tpl-li",{
                    user:data[i].user,
                    date:data[i].date,
                    content:data[i].text
                });
                $("#cm").append(li);
            }
            //limit 默认10
            if(data.length<10){
                $("#cm-load").unbind();
                $("#cm-load").html(function(){
                    return $(this).html().replace("加载更多","已加载全部");
                });
            }
        }
    });
}

$("#cm-load").click(function(){
    moreComment($("#cm").find(".ci").length);
});


//发送评论信息
function sendComment(user,date,text){
    $.ajax({
        url:"action/sendComment.php",
        data:{mid:mid,chapter:chapter,user:user,date:date,text:text},
        dataType:"json",
        success:function(data){
            var li=template("tpl-li",{
                user:data.user,
                date:data.date,
                content:data.text
            });
            $("#cm").prepend(li);
        }
    });
}

Date.prototype.Format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "h+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
        "q+": Math.floor((this.getMonth() + 3) / 3),
        "S": this.getMilliseconds()
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
};

$("#cm-send").click(function(){
    var text=$("#text").val();
    if(text==null||/^\s*$/.test(text)) return;
    var date=new Date().Format("yyyy-MM-dd hh:mm:ss");
    var user=returnCitySN.cname;
    sendComment(user,date,text);
    $("#text").val("");
});
