
//---------------------------------------------------------------------------------------------------------------------
//play.php
$("#bg-submit").click(function(){
    $.post("../../action/sendBarrage.php",{},function(data){
       if(data.ok){

       }else if(data.msg){

       }else{

       }
    });
});

$("#cm-submit").click(function(){
    $.post("../../action/sendComment.php",{},function(data){
       if(data.ok){

       }else if(data.msg){

       }else{

       }
    });
});
