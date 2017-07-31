var vl={};
vl.buffer=[];
vl.init=function(){
    var _this=this;
    ajaxForm.action(null,{
        type:"get",
        url:"search/loadSearch.php",
        data:{key:sechkey},
        success:function(data) {
            if(data.ok){
                _this.buffer=data.data;
                _this.totalPage=Math.ceil(_this.buffer.length/_this.limit);
                if(_this.totalPage<=0){
                    _this.totalPage=1;
                }
                _this.page(1);
            }
        }
    });
};
vl.curPage=1;
vl.totalPage=1;
vl.limit=19;
vl.insertPos=$("#sech-insert");
vl.page=function(p){
    var _this=this;
    if(p<1||p>_this.totalPage) return;
    _this.curPage=p;
    _this.insertPos.parent().find(".row").remove();
    _this.insertPos.parent().find(".page-ctrl").remove();
    var start=(_this.curPage-1)*_this.limit;
    var html1=template("sech-tpl",{data:_this.buffer.slice(start,start+_this.limit),mt:Math});
    _this.insertPos.before(html1);
    var html2=template("pg-tpl",{curPage:_this.curPage,totalPage:_this.totalPage});
    _this.insertPos.before(html2);
};
//
$(function(){
    vl.init();
});
