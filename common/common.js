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