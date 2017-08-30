var upload={};
upload.nodes={
    vShow:$(".content .preview"),
    vInput:function(){ return $(".content #vInput");},
    addBtn:$(".content .addBtn"),
    startBtn:$(".content .startBtn"),
    cancelBtn:$(".content .cancelBtn"),
    fName:$(".content .fName"),
    fSize:$(".content .fSize"),
    vPg:$(".content .pg-wrap .pg"),
    vPer:$(".content .pg-info .per"),
    vSpeed:$(".content .pg-info .speed"),
    vSpare:$(".content .pg-info .spare"),
    vFinish:$(".content .pg-info .finish"),
    submitBtn:$("#submit"),
    titleInput:$("#title"),
    categeryInput:$("#categery")
};
upload.task=null;
upload.data=null;
upload.upSpeed={st:0,sb:0};
upload.init=function(){
    var _this=this;
    _this.initUpload();
    _this.nodes.addBtn.click(function(){
        _this.nodes.vInput().click();
    });
    _this.nodes.startBtn.click(function(){
        if(!_this.data) return;
        var data=_this.data;
        _this.nodes.addBtn.prop("disabled",true);
        _this.nodes.startBtn.prop("disabled",true);
        _this.nodes.cancelBtn.prop("disabled",false);
        $.getJSON("http://"+udomain+"/upload/index.php?_token="+_token+"&_time="+_time,{vInput:data.files[0].name},function(rs){
            data.uploadedBytes = rs.vInput && rs.vInput.size;
            if(data.uploadedBytes==data.files[0].size){
                _this.nodes.startBtn.prop("disabled",true);
                _this.nodes.cancelBtn.prop("disabled",true);
                _this.nodes.addBtn.prop("disabled",false);
                //
                _this.nodes.vFinish.text(_this.formatSize(data.uploadedBytes));
                _this.nodes.vPg.css("width","100%");
                _this.nodes.vPer.text("100%");
                _this.deal(data.files[0]);
            }else{
                _this.task=data.submit();
                _this.upSpeed.st=new Date().getTime();
                _this.upSpeed.sb=data.uploadedBytes;
                _this.task.success && _this.task.success(function(file){
                    _this.nodes.startBtn.prop("disabled",true);
                    _this.nodes.cancelBtn.prop("disabled",true);
                    _this.nodes.addBtn.prop("disabled",false);
                    _this.deal(file.vInput[0]);
                });
            }
        });
    });
    _this.nodes.cancelBtn.click(function(){
        _this.task && _this.task.abort();
        _this.nodes.addBtn.prop("disabled",false);
        _this.nodes.startBtn.prop("disabled",false);
        _this.nodes.cancelBtn.prop("disabled",true);
    });
    _this.nodes.submitBtn.click(function(){_this.submit();})
};
upload.initUpload=function(){
    var _this=this;
    _this.nodes.vInput().fileupload({
        maxChunkSize: 2000000, // 2MB
        dataType: "json",
        paramName:"vInput",
        singleFileUploads:false,
        url:"http://"+udomain+"/upload/index.php?_token="+_token+"&_time="+_time,
        add: function (e, data) {
            var file=data.files[0];
            if(!/^[0-9a-zA-Z_-]+\.mp4$/.test(file.name)){
                _this.log("文件名不符合規則，不能包含除0-9a-zA-Z_-之外的字符");
                return;
            }
            if(file.type!="video/mp4"){
                _this.log("文件類型不被接受，僅支持MP4格式");
                return;
            }
            if(file.size>200*1024*1024||file.size<1*1024*1024){
                _this.log("文件太大或者太小，必須在[1M,200M]之間");
                return;
            }
            //
            _this.showFile(file);
            _this.nodes.startBtn.prop("disabled",false);
            _this.nodes.cancelBtn.prop("disabled",true);
            _this.data=data;
        },
        progressall:function(e,data) {
            var now=new Date().getTime();
            var gapt=(now-_this.upSpeed.st)/1000;
            var gapb=data.loaded-_this.upSpeed.sb;
            var speed=gapb/gapt;
            var spare=(data.total-data.loaded)/speed;
            _this.upSpeed.st=now;
            _this.upSpeed.sb=data.loaded;
            var speed_str=_this.formatSpeed(speed);
            var spare_str=_this.formatSpare(spare);
            //
            _this.nodes.vSpeed.text(speed_str);
            _this.nodes.vSpare.text(spare_str);
            _this.nodes.vFinish.text(_this.formatSize(data.loaded));
            //
            var progress = Math.round(data.loaded/data.total*100);
            _this.nodes.vPg.css("width",progress+"%");
            _this.nodes.vPer.text(progress+"%");
        }
    });
};
upload.log=function(msg){
    alert(msg);
};
upload.formatSpeed=function(speed){
    // byte/s
    if(speed>=1024*1024){
        return Math.round(speed/(1024*1024)) + " M/s";
    }else if(speed>1024){
        return Math.round(speed/1024) + " K/s";
    }else{
        return Math.round(speed) + " B/s"
    }
};
upload.formatSize=function(size){
    //byte
    if(size>1024*1024*1024){
        return Math.round(size/(1024*1024*1024))+"G";
    }else if(size>1024*1024){
        return Math.round(size/(1024*1024))+"M";
    }else if(size>1024){
        return Math.round(size/1024)+"K";
    }else{
        return size+"B";
    }
};
upload.formatSpare=function(spare){
    if(spare==Infinity) return "00:00";
    var h,m,s;
    if(spare>60*60){
        h = Math.floor(spare/(60*60));
        spare-=h*60*60;
        m = Math.floor(spare/60);
        spare-=m*60;
        s = Math.floor(spare);
        if(h<10){
            h="0"+h;
        }
        if(m<10){
            m="0"+m;
        }
        if(s<10){
            s="0"+s;
        }
        return h+":"+m+":"+s;
    }else if(spare>60){
        m = Math.floor(spare/60);
        spare-=m*60;
        s = Math.floor(spare);
        if(m<10){
            m="0"+m;
        }
        if(s<10){
            s="0"+s;
        }
        return m+":"+s;
    }else{
        s = Math.floor(spare);
        if(s<10){
            s="0"+s;
        }
        return "00"+":"+s;
    }
};
upload.deal=function(obj){
    var _this=this;
    ajaxForm.action(null,{
        type:"post",
        url:"http://"+udomain+"/upload/deal.php",
        data:{_token:_token,_time:_time,name:obj.name},
        success:function(data){
            if(data.ok){
                _this.nodes.vShow.prop("src",data.data.png);
                var upload=data.data;
                upload.obj=obj;
                _this.nodes.vShow.data("upload",upload);
            }
        }
    });
};
upload.showFile=function(file){
    var _this=this;
    _this.nodes.fName.text(file.name);
    _this.nodes.fSize.text(_this.formatSize(file.size));
};
//
upload.submit=function(){
    var _this=this;
    var title=_this.nodes.titleInput.val();
    var categery=_this.nodes.categeryInput.val();
    var isUploaded=_this.nodes.vShow.data("upload")!=null;
    if(!isUploaded){
        _this.log("還未上傳視頻");
        return;
    }
    var upload=_this.nodes.vShow.data("upload");
    if(/^\s*$/.test(title)){
        _this.log("未添加標題");
        return;
    }
    if(/^\s*$/.test(categery)){
        _this.log("未添加分類");
        return;
    }
    ajaxForm.action(_this.nodes.submitBtn,{
        type:"post",
        url:"search/sendUpload.php",
        data:{title:title,filename:upload.obj.name,duration:upload.duration,categery:categery,unit:uid},
        success:function(data){
            if(data.ok){
                var id=data.data.id;
                _this.save(id,upload.obj.name);
                location.reload();
            }else if(data.msg){
                _this.log(data.msg);
            }else{
                _this.log("提交失敗");
            }
        }
    })
};
upload.save=function(id,filename){
    var _this=this;
    ajaxForm.action(null,{
        type:"post",
        url:"http://"+udomain+"/upload/save.php",
        data:{id:id,name:filename,_token:_token,_time:_time},
        success:function(data){
            if(data.ok){
                _this.log("上傳成功");
            }else if(data.msg){
                _this.log(data.msg);
            }else{
                _this.log("保存出錯");
            }
        }
    })
};

$(function(){
    upload.init();
});