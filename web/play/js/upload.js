var upload={};
upload.widgets={
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
    _this.widgets.addBtn.click(function(){
        _this.widgets.vInput().click();
    });
    _this.widgets.startBtn.click(function(){
        if(!_this.data) return;
        var data=_this.data;
        _this.widgets.addBtn.prop("disabled",true);
        _this.widgets.startBtn.prop("disabled",true);
        _this.widgets.cancelBtn.prop("disabled",false);
        $.getJSON("http://"+udomain+"/upload/index.php?_token="+_token+"&_time="+_time,{vInput:data.files[0].name},function(rs){
            data.uploadedBytes = rs.vInput && rs.vInput.size;
            if(data.uploadedBytes==data.files[0].size){
                _this.widgets.startBtn.prop("disabled",true);
                _this.widgets.cancelBtn.prop("disabled",true);
                _this.widgets.addBtn.prop("disabled",false);
                //
                _this.widgets.vFinish.text(_this.formatSize(data.uploadedBytes));
                _this.widgets.vPg.css("width","100%");
                _this.widgets.vPer.text("100%");
                _this.deal(data.files[0]);
            }else{
                _this.task=data.submit();
                _this.upSpeed.st=new Date().getTime();
                _this.upSpeed.sb=data.uploadedBytes;
                _this.task.success && _this.task.success(function(file){
                    _this.widgets.startBtn.prop("disabled",true);
                    _this.widgets.cancelBtn.prop("disabled",true);
                    _this.widgets.addBtn.prop("disabled",false);
                    _this.deal(file.vInput[0]);
                });
            }
        });
    });
    _this.widgets.cancelBtn.click(function(){
        _this.task && _this.task.abort();
        _this.widgets.addBtn.prop("disabled",false);
        _this.widgets.startBtn.prop("disabled",false);
        _this.widgets.cancelBtn.prop("disabled",true);
    });
    _this.widgets.submitBtn.click(function(){_this.submit();})
};
upload.initUpload=function(){
    var _this=this;
    _this.widgets.vInput().fileupload({
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
                _this.log("文件类型不被接受，仅支持MP4格式");
                return;
            }
            if(file.size>1024*1024*1024||file.size<100*1024*1024){
                _this.log("文件太大或者太小，必须在[100M,1024M]之间");
                return;
            }
            //
            _this.showFile(file);
            _this.widgets.startBtn.prop("disabled",false);
            _this.widgets.cancelBtn.prop("disabled",true);
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
            _this.widgets.vSpeed.text(speed_str);
            _this.widgets.vSpare.text(spare_str);
            _this.widgets.vFinish.text(_this.formatSize(data.loaded));
            //
            var progress = Math.round(data.loaded/data.total*100);
            _this.widgets.vPg.css("width",progress+"%");
            _this.widgets.vPer.text(progress+"%");
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
                _this.widgets.vShow.prop("src",data.data.png);
                var upload=data.data;
                upload.obj=obj;
                _this.widgets.vShow.data("upload",upload);
            }
        }
    });
};
upload.showFile=function(file){
    var _this=this;
    _this.widgets.fName.text(file.name);
    _this.widgets.fSize.text(_this.formatSize(file.size));
};
//
upload.submit=function(){
    var _this=this;
    var title=_this.widgets.titleInput.val();
    var categery=_this.widgets.categeryInput.val();
    var isUploaded=_this.widgets.vShow.data("upload")!=null;
    if(!isUploaded){
        _this.log("还未上传视频");
        return;
    }
    var upload=_this.widgets.vShow.data("upload");
    if(/^\s*$/.test(title)){
        _this.log("未添加标题");
        return;
    }
    if(/^\s*$/.test(categery)){
        _this.log("未添加分类");
        return;
    }
    ajaxForm.action(_this.widgets.submitBtn,{
        type:"post",
        url:"/search/sendUpload.php",
        data:{title:title,filename:upload.obj.name,duration:upload.duration,categery:categery,unit:uid},
        success:function(data){
            if(data.ok){
                var id=data.data.id;
                _this.save(id,upload.obj.name);
            }else if(data.msg){
                _this.log(data.msg);
            }
        }
    })
};
upload.save=function(id,filename){
    var _this=this;
    ajaxForm.action(null,{
        type:"post",
        url:"http://"+udomain+"/upload/save.php",
        data:{vid:id,name:filename,_token:_token,_time:_time},
        success:function(data){
            if(data.ok){
                _this.log("上传成功");
                location.reload()
            }else if(data.msg){
                _this.log(data.msg);
                _this.saveFail(id);
            }
        }
    });
};
upload.saveFail=function(id){
    ajaxForm.action(null,{
        type:"post",
        url:"/search/sendUploadFail.php",
        data:{id:id}
    });
};
upload.init();
