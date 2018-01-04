var signup={};
signup.inputs={
    email:$("#email"),
    nick:$("#nick"),
    pass1:$("#pass1"),
    pass2:$("#pass2"),
    submitBtn:$("#submit"),
    err:$(".err")
};
signup.log=function(msg){
    var _this=this;
    _this.inputs.err.html(msg);
};
signup.init=function(){
    var _this=this;
    _this.inputs.submitBtn.click(function(){
        _this.send();
    });
};
signup.send=function(){
    var _this=this;
    var email=_this.inputs.email.val();
    var nick=_this.inputs.nick.val();
    var pass=_this.inputs.pass1.val();
    var pass1=_this.inputs.pass2.val();
    if(!/^[0-9a-zA-Z._-]+@[0-9a-zA-Z._-]+$/.test(email)){
        _this.log("邮箱格式不正确");
        return;
    }
    if(!nick){
        _this.log("昵称不符合规范");
    }
    if(!/^[0-9a-zA-Z_-]{8,15}$/.test(pass)){
        _this.log("密码不符合规范");
        return;
    }
    if(pass!=pass1){
        _this.log("密码输入不一致");
        return;
    }
    ajaxForm.action(this,{
        type:"post",
        url:"/action/login/signup.php",
        data:{email:email,nick:nick,pass:pass},
        success:function(data){
            if(data.ok){
                location.href="signin.php";
            }else if(data.msg){
                _this.log(data.msg);
            }
        }
    });
};
signup.init();