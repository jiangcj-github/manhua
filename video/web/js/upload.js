var upload={};
upload.nodes={
    vShow:$(".content .preview"),
    vInput:$(".content #vInput"),
    addBtn:$(".content .addBtn"),
    startBtn:$(".content .startBtn"),
    cancelBtn:$(".content .cancelBtn"),
    vPg:$(".content .pg-wrap .pg"),
    vPer:$(".content .pg-info .per"),
    vSpeed:$(".content .pg-info .speed"),
    vSpare:$(".content .pg-info .spare")
};
upload.task=null;
upload.upSpeed={st:0,sb:0};
upload.onChange=function(){
    var _this=this;
    _this.nodes.startBtn.prop("disabled",false);
    _this.nodes.cancelBtn.prop("disabled",false);
};
upload.init=function(){
    var _this=this;
    _this.initUpload();
    _this.nodes.vInput.attr("onchange","upload.onChange()");
    _this.nodes.addBtn.click(function(){_this.nodes.vInput.click();});
    _this.nodes.cancelBtn.click(function(){_this.task && _this.task.abort();});
};
upload.initUpload=function(){
    var _this=this;
    _this.nodes.vInput.fileupload({
        maxChunkSize: 2000000, // 2MB
        dataType: "json",
        paramName:"vInput",
        singleFileUploads:false,
        url:"http://lindakai.com/upload/index.php?_token="+_token+"&_time="+_time,
        add: function (e, data) {
            var file=data.files[0];
            if(!/^[0-9a-zA-Z_-]+\.mp4$/.test(file.name)){
                log("文件名不符合規則，不能包含除0-9a-zA-Z_-之外的字符");
                return;
            }
            if(file.type!="video/mp4"){
                log("文件類型不被接受，僅支持MP4格式");
                return;
            }
            if(file.size>200*1024*1024||file.size<1*1024*1024){
                log("文件太大或者太小，必須在[1M,200M]之間");
                return;
            }
            _this.showFile(file);
            var that = this;
            _this.nodes.startBtn.click(function(){
                $.getJSON("http://lindakai.com/upload/index.php?_token="+_token+"&_time="+_time,{vInput:data.files[0].name},function(rs){
                    data.uploadedBytes = rs.vInput && rs.vInput.size;
                    if(data.uploadedBytes==data.files[0].size){
                        var name=data.files[0].name;
                        _this.nodes.startBtn.prop("disabled",true);
                        _this.nodes.cancelBtn.prop("disabled",true);
                        _this.deal(name);
                    }else{
                        _this.task=data.submit();
                        _this.upSpeed.st=new Date().getTime();
                        _this.upSpeed.sb=data.uploadedBytes;
                        _this.task.success && _this.task.success(function(file){
                            var name=file.vInput[0].name;
                            _this.nodes.startBtn.prop("disabled",true);
                            _this.nodes.cancelBtn.prop("disabled",true);
                            _this.deal(name);
                        });
                    }
                });
            });
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
            console.log(speed_str);
            console.log(spare_str);
            //
            var progress = Math.round(data.loaded/data.total*100);
            _this.nodes.vPg.css("width",progress+"%");
            _this.nodes.vPer.text(progress+"%");
        }
    });
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
    //s
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
        return h+"時"+m+":"+s;
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
        return s;
    }
};
upload.deal=function(name){
    var _this=this;
    ajaxForm.action(null,{
        type:"post",
        url:"http://lindakai.com/upload/deal.php",
        data:{_token:_token,_time:_time,name:name},
        success:function(data){
            if(data.ok){
                _this.nodes.vShow.prop("src",data.data.png);
                console.log(data.data);
            }
        }
    });
};
upload.showFile=function(file){
    console.log(file);
};

$(function(){
    upload.init();
});