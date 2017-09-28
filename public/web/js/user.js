
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

function openchatbox(userid) {
    // 每次打开聊天窗口初始化聊天页数
    window.chatpage = 1;
    // 重置聊天box
    $(".chatbox").children().remove();
    getchathistory(userid);

}

function getchathistory(userid) {
    $.post("/getchathistory",{"userid":userid,"page":window.chatpage},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0 && window.chatpage!=1) {
                toast("没有更多了"); return ;
            }
            var tmpcls = "tmp"+(new Date()).getTime();
            $(".chatbox").append("<div class='"+tmpcls+"' ></div>");
            for( var i=res.length-1;i>=0;i-- ) {
                // 我方是发送方
                if( res[i].fid == userid ) {
                    var item = `<div class="rightchat">
                                    <div class="chathead" style="background-image:url(/head/${res[i].fid});" ></div>
                                    <div class="chatcontent">
                                    ${chatmessage(res[i].content,res[i].fid,res[i].type,userid)}
                                        <div class="chattime" style="text-align:right;" >
                                            ${res[i].stime}
                                        </div>
                                    </div>
                                    <div style="clear:both" ></div>
                                </div>`;
                }else{
                    var item = `<div class="leftchat">
                                    <div class="chathead" style="background-image:url(/head/${res[i].fid});" ></div>
                                    <div class="chatcontent">
                                    ${chatmessage(res[i].content,res[i].fid,res[i].type,userid)}
                                        <div class="chattime" >
                                            ${res[i].stime}
                                        </div>
                                    </div>
                                    <div style="clear:both" ></div>
                                </div>`;
                }
                $("."+tmpcls).append(item);
            }
            if( window.chatpage > 1 ) {
                $(".chatbox").prepend($("."+tmpcls));
            }else{
                $(".chatbox").append($("."+tmpcls));
            }

            window.chatpage++;
            $('#myModal3').modal('show');
        }
    })
}

function chatmessage(message,fid,type,userid) {
    console.log(type);
    if( type == "2" ) {
        console.log("zhaohu");
        if( fid == userid ) {
            return "我给Ta打了个招呼";
        }else{
            return "Ta给我打了个招呼";
        }
    }else{
        return message;
    }

}
// 获取好友列表

function getchatlist(userid) {
    if( window.friendpage ) {
        window.friendpage++;
    }else{
        window.friendpage = 1;
    }
    $.post("/getchatlist",{'userid':userid,"page":window.friendpage},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0  && window.friendpage!=1) {
                toast("没有更多了"); return ;
            }
            for( var i=0;i<res.length;i++ ) {
                var item = `<div class="useritem">
                                <a href="/user/${res[i].uid}"><div class="userhead" style="background-image:url(/head/${res[i].uid});"></div></a>
                                <div class="userinfo">
                                    <div>${res[i].uname}</div>
                                    <div>${res[i].age}岁 ${res[i].mryst}</div>
                                    <div>${res[i].addr}</div>
                                </div>
                                <span onclick="delchat(${res[i].uid})" class="closeitem">&times;</span>
                            </div>`;
                $(".friendbox").append(item);
            }
        }
    })
}

function getphotos(userid) {
    if( window.photopage ) {
        window.photopage++;
    }else{
        window.photopage = 1;
    }
    $.post("/getphotos",{'userid':userid,"page":window.photopage},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0 && window.photopage!=1 ) {
                toast("没有更多了"); return ;
            }
            for( var i=0;i<res.length;i++ ) {
                var item = `<div class="imgdiv2" onclick="img2big(this)" style="background-image:url(/web/data/images/${res[i].pic})" ></div>`;
                $(".photosbox").append(item);
            }
        }
    })
}

function getdongtais(userid) {
    if( window.dongtaipage ) {
        window.dongtaipage++;
    }else{
        window.dongtaipage = 1;
    }
    $.post("/getdongtais",{'userid':userid,"page":window.dongtaipage},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0 && window.dongtaipage!=1) {
                toast("没有更多了"); return ;
            }
            for( var i=0;i<res.length;i++ ) {
                var pics = res[i].imgs.split("#");
                var item = `<div>
                        <div>${res[i].content}</div>
                        ${imgs2div(pics)}
                        <div style="clear:both;height:20px;" ></div>
                        <div style="margin-bottom:20px">
                            <a href="/user/{{$dongtai[$i]->uid}}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/${res[i].uid});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle" ></div></a>
                            <span>发布于 ${res[i].ftime}</span>
                            <button onclick="dongtaicmtmp(${res[i].id},'dianzan')" style="outline:none;margin-left:10px;" type="button" class="btn btn-default btn-sm">
                                <img src="/web/images/xihuan.png" style="height:18px;"><span style="margin-left:10px;" >点赞${res[i].zancnt}</span>
                            </button>
                            <button onclick="dongtaicmtmp(${res[i].id},'liuyan')" style="outline:none;" type="button" class="btn btn-default btn-sm">
                                <img src="/web/images/liuyan.png" style="height:15px;"><span style="margin-left:10px;" >评论${res[i].cmcnt}</span>
                            </button>
                            <button onclick="zhankai(${res[i].id},this)" style="outline:none;" type="button" class="btn btn-default btn-sm">
                                <img src="/web/images/zhankai.png" style="width:10px;"><span style="margin-left:10px;" >展开评论</span>
                            </button>
                            <div style="height:100px;width:100%;border:1px solid #eee;margin-top:10px;display: none;" >

                            </div>
                        </div>
                    </div>`;
                $(".dongtaibox").append(item);
            }
        }
    })
}

function imgs2div(pics) {
    var tmp = "";
    for( var i=0;i<pics.length;i++ ) {
        tmp+="<div class='imgdiv' onclick='img2big(this)' style='background-image:url(/web/data/images/"+pics[i]+")' ></div>";
    }
    return tmp;
}

function getliuyans(userid) {
    if( window.liuyanpage ) {
        window.liuyanpage++;
    }else{
        window.liuyanpage = 1;
    }
    $.post("/getliuyans",{'userid':userid,"page":window.liuyanpage},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0 && window.liuyanpage!=1 ) {
                toast("没有更多了"); return ;
            }
            for( var i=0;i<res.length;i++ ) {
                var item = `<div style="margin:20px 0;vertical-align: middle;">
                            <div onclick="location.href='/user/${res[i].fid}'" style="display: inline-block;height:60px;width:60px;background-image:url(/head/${res[i].fid});background-size:cover;background-position:center;border-radius:30px;vertical-align: middle;float:left;cursor:pointer;" ></div>
                            <div style="margin:15px 0;font-size:16px;padding:10px;float:left;max-width:1100px;margin-left:20px;border-radius:5px;">${res[i].content}</div>
                            <div style="clear:both;margin-left:90px;color:#999;" >
                                ${res[i].ltime}
                            </div>
                        </div>`;
                $(".liuyanbox").append(item);
            }
        }
    })
}

function getyoujis(userid) {
    if( window.youjipage ) {
        window.youjipage++;
    }else{
        window.youjipage = 1;
    }
    $.post("/getyoujis",{'userid':userid,"page":window.youjipage},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0 && window.youjipage!=1 ) {
                toast("没有更多了"); return ;
            }
            for( var i=0;i<res.length;i++ ) {
                var item = `<a href="/youji/detail/${res[i].id}"><div class="youjiitem">
                        <div class="youjipic" style="background-image:url(/web/data/images/${res[i].pic})" ></div>
                            <div class="youjiuserhead" style="background-image:url(/head/${res[i].uid})" ></div>
                        <div class="youjititle">
                            ${res[i].title}
                        </div>
                        <div class="youjitime">
                            ${res[i].ytime}
                        </div>
                    </div></a>`;
                $(".youjibox").append(item);
            }
        }
    })
}

function getshoporder(userid) {
    if( window.shoporderpage ) {
        window.shoporderpage++;
    }else{
        window.shoporderpage = 1;
    }
    $.post("/getshoporders",{'userid':userid,"page":window.shoporderpage},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0 && window.shoporderpage!=1 ) {
                toast("没有更多了"); return ;
            }
            for( var i=0;i<res.length;i++ ) {
                var item = `<div style="height:130px;width:100%;border:1px solid #eee;padding:15px;position: relative;margin-bottom:20px;" >
                        <a href="/shop/detail/${res[i].shopid}"><div style="height:100px;width:100px;float:left;background-image:url(/admin/data/images/${res[i].pictures});background-size:cover;background-position:center;cursor: pointer;" ></div></a>
                        <div style="margin-left:10px;float:left;font-size:14px;">
                            <a href="/shop/detail/${res[i].shopid}"><p style="font-weight: bold">${res[i].title}</p></a>
                            <p style="color:#666;font-size:13px;">颜色：${res[i].color}　尺寸：${res[i].chicun}　件数：${res[i].num}　件　收货地址：${res[i].addr}</p>
                            <p style="color:#666;font-size:13px;">留言：${res[i].liuyan == ''?res[i].liuyan:'无'}</p>
                            <p style="color:#666;font-size:13px;">物流状态：${res[i].kuaidi == 0 ? "等待发货" : res[i].kuaidi}</p>
                        </div>
                        <span style="color:cadetblue;font-weight:bold;font-size:20px;position: absolute;right:15px;top:15px;" >付款：${res[i].num*res[i].price}</span>
                    </div>`;
                $(".shoporderbox").append(item);
            }
        }
    })
}

function gettubuorder(userid) {
    if( window.tubuorderpage ) {
        window.tubuorderpage++;
    }else{
        window.tubuorderpage = 1;
    }
    $.post("/gettubuorders",{'userid':userid,"page":window.tubuorderpage},function(d){
        if( res = ajaxdata(d) ) {
            if( res.length == 0 && window.tubuorderpage!=1 ) {
                toast("没有更多了"); return ;
            }
            for( var i=0;i<res.length;i++ ) {
                var item = `<div style="height:130px;width:100%;border:1px solid #eee;padding:15px;position: relative;margin-bottom:20px;" >
                        <a href="/tubu/tubudetail/${res[i].id}"><div style="height:100px;width:100px;float:left;background-image:url(/admin/data/images/${res[i].pictures});background-size:cover;background-position:center;cursor: pointer;" ></div></a>
                        <div style="margin-left:10px;float:left;font-size:14px;">
                            <a href="/tubu/tubudetail/${res[i].id}"><p style="font-weight: bold">${res[i].title}</p></a>
                            <p style="color:#666;font-size:13px;">领队：${res[i].leader}　联系电话：${res[i].phone}　交通方式：${res[i].jiaotong}　目的地：${res[i].mudidi}</p>
                            <p style="color:#666;font-size:13px;">出发时间：${res[i].startday}　集合时间：${res[i].jihetime}　集合地点：${res[i].jihedidian}</p>
                            <p style="color:#666;font-size:13px;">活动内容：${res[i].neirong}</p>
                        </div>
                        <span style="color:cadetblue;font-weight:bold;font-size:20px;position: absolute;right:15px;top:15px;" >付款：${res[i].price}</span>
                    </div>`;
                $(".tubuorderbox").append(item);
            }
        }
    })
}

