
//表格控件列排序,搜索
/**
 *  chrome v8引擎默认的sort函数使用快速排序，相等元素会乱序，因此使用下面自定义的插入排序算法
 */
function directInsertionSort(array,cmp) {
    var length = array.length, index, current;
    for (var i = 1; i < length; i++) {
        index = i - 1;
        current = array[i];
        while(index >= 0 && cmp(array[index],current)>0) {
            array[index+1] = array[index];
            index--;
        }
        if( index+1 !== i){
            array[index+1] = current;
        }
    }
    return array;
}

/**
 * 解决模板化后表格事件无法绑定
 * @param obj
 */
$(document).find(".tb_header>.tb_tr>div.sortable").click(function(e){
    var x = e.pageX - $(e.currentTarget).offset().left;
    var w=$(e.currentTarget).outerWidth();
    if (w - x <= 10) {
        return false;
    }
    $(this).parent(".tb_tr").children(".sort-asc").not(this).removeClass("sort-asc");
    $(this).parent(".tb_tr").children(".sort-desc").not(this).removeClass("sort-desc");
    var index=$(this).parent(".tb_tr").children("div").index(this);
    var trs=$(this).parents(".tb_table").children(".tb_body").children(".tb_tr");
    if($(this).hasClass("sort-asc")){
        //desc
        $(this).removeClass("sort-asc");
        $(this).addClass("sort-desc");
        trs=directInsertionSort(trs,function(a,b){
            var atext=$(a).children("div").eq(index).text();
            var btext=$(b).children("div").eq(index).text();
            if(!isNaN(atext-btext)){
                return btext-atext;
            }else{
                return atext<btext;
            }
        });
        $(this).parents(".tb_table").children(".tb_body").append(trs);
    }else{
        //asc
        $(this).removeClass("sort-desc");
        $(this).addClass("sort-asc");
        trs=directInsertionSort(trs,function(a,b){
            var atext=$(a).children("div").eq(index).text();
            var btext=$(b).children("div").eq(index).text();
            if(!isNaN(btext-atext)){
                return atext-btext;
            }else{
                return atext>btext;
            }
        });
        $(this).parents(".tb_table").children(".tb_body").append(trs);
    }
});
$(document).find(".tb_header>.tb_tr>div").on("mousemove",function(e){
    var x = e.pageX - $(e.currentTarget).offset().left;
    var w=$(e.currentTarget).outerWidth();
    if (w - x <= 10) {
        $(e.currentTarget).css("cursor", "col-resize");
    } else {
        $(e.currentTarget).css("cursor", "pointer");
    }
});
$(document).find(".tb_header>.tb_tr>div").on("mousedown",function(e){
    var x = e.pageX - $(e.currentTarget).offset().left;
    var w=$(e.currentTarget).outerWidth();
    if (w - x <= 10) {
        isRz=true;
        rzObj=e.currentTarget;
        mx=e.pageX;

    }
});

var rzObj=0,isRz=false;

var mx=0;

$(document).on("mousemove",function(e){
    if(isRz){
        var dx=e.pageX-mx;
        var rzIdx=$(rzObj).parent(".tb_tr").children("div").index(rzObj);
        $(rzObj).css("width","+="+dx+"px");
        $(rzObj).parents(".tb_table").find(".tb_body .tb_tr").each(function() {
            $(this).children("div").eq(rzIdx).css("width", "+=" + dx + "px");
        });
        mx=e.pageX;
    }
});

$(document).on("mouseup",function(){
    isRz=false;
});
