//
$(function(){
    //lazyload
    $("img.lazy").lazyload({effect: "fadeIn"});
    //加载评论信息
    $.ajax({
        url:"",
        data:{mid:mid,chapter:chapter,offset:0},
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
        }
    });
});

//加载更多评论信息
function moreComment(){
    $.ajax({
        url:"",
        data:{mid:mid,chapter:chapter,offset:offset},
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
        }
    });
}

