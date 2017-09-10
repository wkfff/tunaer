
function save(){
    var uname = $("input[name=uname]").val();
    var sex = $("input[name=sex]:checked").val();
    var age = $("input[name=age]").val();
    var intro = $("textarea[name=intro]").val();
    var mryst = $("input[name=mryst]:checked").val();
    var addr = $("#pro").val()+"-"+$("#city").val();

    if( age != '' && !/^[1-9]{1}\d{1}$/.test(age) ) {
        toast("请填写正确的年龄,例如：23 , 34"); return ;
    }
    $.post("/updateuserinfo",{
        "uname":uname,"sex":sex,"age":age,"intro":intro,"mryst":mryst,"addr":addr
    },function(data){
        var d = ajaxdata(data);
        if( d ) {
            toast("更新成功");
            location.reload();
        }
    })
}

function updatehead(that) {
    var file = that.files[0];
    if( checkFileAllow(file,"image",3) ) {
        var fd = new FormData();
        fd.append("file" , file );
        var oXHR = new XMLHttpRequest();
        oXHR.open('POST', "/updatehead");
        oXHR.onreadystatechange = function() {
            if (oXHR.readyState == 4 && oXHR.status == 200) {
                var d = oXHR.responseText; // 返回值
                if( ajaxdata(d) ) {
                    location.reload();
                }
            }
        }
        oXHR.send(fd);
    }
}

function uploadImg(t) {
    var file = t.files[0];
    if( !checkFileAllow(file,'image',4) ) {
        return false;
    }
    var fd = new FormData();
    fd.append("file" , file );
    var oXHR = new XMLHttpRequest();
    oXHR.open('POST', "/uploadimg");
    oXHR.onreadystatechange = function() {
        if (oXHR.readyState == 4 && oXHR.status == 200) {
            var d = oXHR.responseText; // 返回值
            var img =`<div class="imgdiv" ondblclick="$(this).remove()"  style="background-image:url(/web/data/images/${d})" ></div>`;
            $(".dongtaipics").append(img);
        }
    }
    oXHR.send(fd);
}
function uploadImg2(t) {
    var file = t.files[0];
    if( !checkFileAllow(file,'image',4) ) {
        return false;
    }
    var fd = new FormData();
    fd.append("file" , file );
    var oXHR = new XMLHttpRequest();
    oXHR.open('POST', "/uploadimg");
    oXHR.onreadystatechange = function() {
        if (oXHR.readyState == 4 && oXHR.status == 200) {
            $(".youjipics").children().remove();
            var d = oXHR.responseText; // 返回值
            var img =`<div class="imgdiv" ondblclick="$(this).remove()"  style="background-image:url(/web/data/images/${d})" ></div>`;
            $(".youjipics").append(img);
        }
    }
    oXHR.send(fd);
}
// 上传相册
function uploadphoto(t) {
    var file = t.files[0];
    if( !checkFileAllow(file,'image',10) ) {
        return false;
    }
    var fd = new FormData();
    fd.append("file" , file );
    var oXHR = new XMLHttpRequest();
    oXHR.open('POST', "/uploadxiangce");
    oXHR.onreadystatechange = function() {
        if (oXHR.readyState == 4 && oXHR.status == 200) {
            var d = oXHR.responseText; // 返回值
            if( ajaxdata(d) ) {
                location.reload();
            }
        }
    }
    oXHR.send(fd);
}
// 留言
function liuyan(t){
    var content = $(t).parent("div").children("textarea").val();
    if( $.trim(content) == '' ) {
        toast("请添加留言内容"); return;
    }
    $.post("/liuyan",{"userid":window.uid,"content":content},function(d){
        if( ajaxdata(d) ) {
            location.reload();
        }
    })
}

function fadongtai(t) {
    var content = $(".dongtai div").children("textarea").val();
    if( $.trim(content) == '' ) {
        toast("请填写动态内容");return;
    }

    var pics = $(".dongtaipics div");
    var tmp = new Array();
    for( var i=0;i<pics.length;i++ ) {
        var url = $(pics[i]).css("background-image");
        var pic = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];
        tmp.push(pic);
    }
    if( tmp.length == 0 ) {
        toast("至少添加一张图片"); return ;
    }
    var imgs = tmp.join("#");
    $.post("/fadongtai",{"content":content,"imgs":imgs},function(d){
        if( ajaxdata(d) ) {
            toast("发布成功");
            location.href = "/user/"+window.uid+"#dongtai";
            location.reload();
        }
    })
}
function dongtaicmtmp(did,type){
    window.dongtai_id =  did;
    if( type == 'liuyan' ) {
        $("#myModal2").modal("show");
    }else{
        dongtaicm(1);
    }
}
function dongtaipinglun() {
    var content = $("textarea[name=comment]").val();
    // alert(content);return;
    dongtaicm(content);
    $("#myModal2").modal("hide");
}
function dongtaicm(content) {
    // alert(content);return;
    $.post("/dongtai/pinglun",{"did":window.dongtai_id,"content":content},function(d){
        if(ajaxdata(d)) {
            toast("操作成功");
        }
    })
}
// 展开评论
function zhankai(did,t) {
    if($(t).parent("div").children("div").children("div").length != 0 ) {
        $(t).parent("div").children("div").slideUp(function(){
            $(t).parent("div").children("div").children("div").remove();
        });
        return ;
    }
    $.post("/dongtai/cmlist",{"did":did},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0 ) {
                toast("还没有评论");return ;
            }
            for( var i=0;i<res.length;i++ ) {
                var cmitem = `<div style="height:30px;line-height:30px;margin:10px;">
                                    <a href="/user/${res[i].uid}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/${res[i].uid}}});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle" ></div></a>
                                    <div style="display: inline-block;margin-left:10px;color:#444">${res[i].content}</div><span style="margin-left:20px;font-size:13px;color:#999;">${res[i].ctime}</span>
                                </div>`;
                $(t).parent("div").children("div").append(cmitem);
            }
            $(t).parent("div").children("div").slideDown();
        }
    })
}

function changetab(tab) {
    $(".tab").css("display","none");
    $("."+tab).css("display","block");
    location.href=location.href.split("#")[0]+"#"+tab;
}

function fabuyouji() {
    if( $(".youjipics").children().length == 0 ) {
        toast("请上传封面");return ;
    }
    var tuwen = um.getContent();
    var title = $(".youji input").val();
    if( $.trim(title) == '' || $.trim(um.getContentTxt()) == '' ) {
        toast("请填写没一项内容");return;
    }
    var url = $($(".youjipics div")[0]).css("background-image");
    var pic = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];

    $.post("/youji/fabu",{"title":title,"tuwen":tuwen,"pic":pic},function(d){
        if( ajaxdata(d) ) {
            toast("发布成功");
            location.reload();
        }
    })
}

function sendchat(userid) {
    var content = $("#chatcontent").val();

    if( $.trim(content) == '' ) {
        toast("请输入聊天内容"); return;
    }
    $.post("/sendchat",{"userid":userid,"content":content},function(d){
        if( ajaxdata(d) ) {
            toast("发送成功");
        }
    })
}