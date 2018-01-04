var vl={};
vl.buffer={};
vl.init=function(){
    var _this=this;
    ajaxForm.action(null,{
        type:"get",
        url:"/search/loadVideoInfo.php",
        success:function(data) {
            if(data.ok){
                var count=parseInt(data.data[0]["count"]);
                _this.totalPage=Math.ceil(count/_this.limit);
                if(isNaN(_this.totalPage)){
                    _this.totalPage=1;
                }
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
vl.pageOk=function(){
    var _this=this;
    var html1=template("sech-tpl",{data:_this.buffer[_this.curPage],mt:Math});
    _this.insertPos.before(html1);
    var html2=template("pg-tpl",{curPage:_this.curPage,totalPage:_this.totalPage});
    _this.insertPos.before(html2);
};
vl.page=function(p){
    var _this=this;
    if(p<1||p>_this.totalPage) return;
    _this.curPage=p;
    _this.insertPos.parent().find(".row").remove();
    _this.insertPos.parent().find(".page-ctrl").remove();
    if(_this.buffer[_this.curPage]){
        _this.pageOk();
        return;
    }
    ajaxForm.action(null,{
        type:"get",
        url:"/search/loadCtVote.php",
        data:{offset:(_this.curPage-1)*_this.limit,limit:_this.limit},
        success:function(data) {
            if(data.ok){
                _this.buffer[_this.curPage]=data.data;
                _this.pageOk();
            }
        }
    });
};
//
$(function(){
    vl.init();
});
