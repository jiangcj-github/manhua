var signin={};
signin.inputs={
    err:$(".err"),
    email:$("#email"),
    pass:$("#pass"),
    auto:$("#auto"),
    submitBtn:$("#submit")
};
signin.init=function(){
    var _this=this;
    _this.inputs.submitBtn.click(function(){
        _this.send();
    });
};
signin.log=function(msg){
    var _this=this;
    _this.inputs.err.html(msg);
};
signin.send=function(){
    var _this=this;
    var email=_this.inputs.email.val();
    var pass=_this.inputs.pass.val();
    var auto=_this.inputs.auto.is(":checked");
    if(!/^[0-9a-zA-Z._-]+@[0-9a-zA-Z._-]+$/.test(email)){
        _this.log("邮箱格式不正确");
        return;
    }
    if(!/^[0-9a-zA-Z_-]{8,15}$/.test(pass)){
        _this.log("密码格式不正确");
        return;
    }
    pass=md5(pass);
    ajaxForm.action(this,{
        type:"post",
        url:"/action/login/signin.php",
        data:{email:email,pass:pass},
        success:function(data){
            if(data.ok){
                if(auto){
                    setCookie("autosign","auto",365*100);
                    setCookie("user",user,365*100);
                    setCookie("pass",pass,365*100);
                }
                location.reload();
            }else if(data.msg){
                _this.log(data.msg);
            }
        }
    });
};
signin.init();