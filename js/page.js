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
        url:"/php/loadComment.php",
        data:{mid:mid,chapter:chapter,offset:offset},
        dataType:"json",
        success:function(data){
            for(var i=0;i<data.length;i++){
                var li=template("tpl-li",{
                    user:data[i].user,
                    date:data[i].date,
                    text:data[i].text
                });
                $("#cm").append(li);
                offset++;
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

