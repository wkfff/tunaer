
// 打开登陆框
function openlogion() {
    // localStorage.setItem("enterurl",window.location.href);
    $("#regmodal").modal("hide");
    $("#loginmodal").modal("show");

    // var iframe = "<div onclick='$(this).toggle();' id='loginbg' style='height:100%;width:100%;position:fixed;z-index:1060;background:rgba(0,0,0,0.3);left:0px;top:0px;display:none' ><iframe src='/login' frameborder='0' style='width:100%;height: 100%;background: #fff;position: absolute;left: 0%;top: 0%;box-shadow: 0 5px 16px rgba(0, 0, 0, 0.8);border-radius: 4px;z-index:1;'></iframe></div>";
    // $("body").append(iframe);
    // setTimeout(function(){
    //     $("#loginbg").css("display","block");
    // },100)
}
function lg_login() {
    var phone = $.trim( $(" input[name='lg-phone']").val() );
    var passwd = $.trim( $(" input[name='lg-passwd']").val() );
    var code = $.trim( $(" input[name='lg-code']").val() );
    $.post("/login",{
        "phone":phone,
        "passwd":passwd,
        "verifycode":code
    },function(data){
        // alert(data);
        var res = ajaxdata(data);
        if( res ) {
            localStorage.setItem("login_token",res);
            location.reload();
        }
    })
}
// 关闭登录框
function closelogin() {
    $("#loginbg").remove();
}
// 打开登陆框
function openreg() {
    $("#loginmodal").modal("hide");
    $("#regmodal").modal("show");
    // var iframe = "<div onclick='$(this).toggle();' id='regbg' style='height:100%;width:100%;position:fixed;z-index:1060;background:rgba(0,0,0,0.3);left:0px;top:0px;display:none' ><iframe src='/register' frameborder='0' style='width: 600px;height: 360px;background: #fff;position: absolute;left: 50%;top: 50%;margin-left: -300px;margin-top: -200px;box-shadow: 0 5px 16px rgba(0, 0, 0, 0.8);border-radius: 4px;z-index:1;'></iframe></div>";
    // $("body").append(iframe);
    // setTimeout(function(){
    //     $("#regbg").css("display","block");
    // },100)
}
function sendcode() {
    var phone = $.trim( $("input[name='rg-phone']").val() );
    var r = /^1[23456789]{1}\d{9}$/;
    if( !r.test(phone) ) {
        toast("手机格式错误"); return false;
    }
    $.post("/sendcode",{'phone':phone},function(data){
        var res = ajaxdata(data);
        $("#sendcodebtn").removeAttr("onclick");
        $("#sendcodebtn").text("已发送");
        toast("发送成功，请注意查收");
    })
}
function sendcode2() {
    var phone = $.trim( $("input[name='ql-phone']").val() );
    var r = /^1[23456789]{1}\d{9}$/;
    if( !r.test(phone) ) {
        toast("手机格式错误"); return false;
    }
    $.post("/sendcode",{'phone':phone},function(data){
        var res = ajaxdata(data);
        $(".sendcodebtn").removeAttr("onclick");
        $(".sendcodebtn").text("已发送");
        toast("发送成功，请注意查收");
    })
}
function rg_register() {
    var phone = $.trim( $(" input[name='rg-phone']").val() );
    var passwd = $.trim( $(" input[name='rg-passwd']").val() );
    var code = $.trim( $(" input[name='rg-code']").val() );
    $.post("/register",{
        "phone":phone,
        "passwd":passwd,
        "code":code
    },function(data){
        var res = ajaxdata(data);
        if( res ) {
            localStorage.setItem("login_token",res);
            location.reload();
        }
    })
}
function ql_register() {
    var phone = $.trim( $("input[name='ql-phone']").val() );
    var passwd = $.trim( $("input[name='ql-passwd']").val() );
    var code = $.trim( $("input[name='ql-code']").val() );
    $.post("/register",{
        "phone":phone,
        "passwd":passwd,
        "code":code,
        "qqid":localStorage.getItem("qq_openid"),
        "wxid":localStorage.getItem("wx_openid")
    },function(data){
        var qqdata = JSON.parse(localStorage.getItem("qqdata"));
        var res = ajaxdata(data);
        if( res ) {
            localStorage.setItem("login_token",res);
            $.post("/inituserinfo",{
                "uname":qqdata.nickname,"sex":qqdata.gender,"age":parseInt((new Date().getFullYear() - qqdata.year)),"head":qqdata.figureurl_qq_2,"addr":qqdata.city
            },function(d){
                if( ajaxdata(d) ) {
                    location.href = "/";
                }
            })
        }
    })
}
// 第三方登录
function otherlogin(openid,type) {
    $.post("/otherlogin",{"openid":openid,"type":type},function(d){
        var res = ajaxdata(d);
        if( res ) {
            localStorage.setItem("login_token",res);
            location.href = "/";
        }else{
            if( type == 'qq' ) {
                var data = QC.api("get_user_info", {
                    "access_token":localStorage.getItem("qq_access_token"),
                    "openid":localStorage.getItem("qq_openid"),
                    "oauth_consumer_key":localStorage.getItem("101428001"),
                }, "json", "GET").success(function(s){
                    localStorage.setItem("qqdata",JSON.stringify(s.data));
                    $("#qqlogin").modal("show");
                });
            }else{
                $("#wxlogin").modal("show");
            }

        }
    })
}
// 关闭登录框
function closereg() {
    $("#regbg").remove();
}
// 吐丝提示
function toast(title) {

    $(".toast").remove();
    clearTimeout(window.toastst);
    var tmp = "<div style='height:0px;width:100%;position:fixed;left:0px;bottom:250px;;text-align:center;line-height:50px;z-index:1070' class='toast'><span style='background:#194C8E;color:#fff;padding:14px 30px;border-radius:10px;font-size:16px;font-weight:bold'>"+title+"</span></div>";
    $("body").append(tmp);
    window.toastst = setTimeout(function(){
        $(".toast").fadeOut(1000);
    },1500)
}
// 过滤ajax数据
function ajaxdata(data) {
    var qianzhui = data.substr(0,3);
    switch(qianzhui) {
        case "400":
            toast(data.substr(4)); return false;
        case "200":
            return data.substr(4);
    }
    switch(data) {
        case "":
            return false;
        case "nologin":
            openlogion();return false;
        case "noaccess":
            toast("access deny"); return false;
    }
    if( /^[\d]{10}\.[a-zA-Z]{3,5}$/.test(data) ) {
        return data;
    }
    return JSON.parse(data);
}
function checkFileAllow(file,type,size) {
    if( !file ) {
        return false;
    }
    var patt=new RegExp(type);
    if( !patt.test(file.type) ) {
        toast("不支持的文件格式");
        return false;
    }

    if( parseInt(file.size/1000000) > size ) {
        toast("文件超过 "+(size+1)+"M ");
        return false;
    }

    return true;
}

function img2big(t) {
    var src = '';
    // 不管是 div背景  还是 图片都能获取到图片 url
    if( t.nodeName == 'IMG' || t.nodeName == 'img' ) {
        src = $(t).attr('src').replace("\"",'');
    }else{
        var t = $(t).css("background-image").replace(/\"/g, "").split('(').pop();
        src = ""+t.substr(0,t.length-1);
    }
    // 先把这个图片放到一个自然宽高的隐藏容器
    var tmpImg = "<img src='"+src+"' style='display:none' class='tempImg' > ";
    $("body").append(tmpImg);
    // 获取图片原始大小
    var imgWidth = $(".tempImg").width();
    var imgHeight = $(".tempImg").height();
    // console.log(imgWidth+":"+imgHeight);

    // 如果图片原始大小超过 900x600 就要缩放   6000*4000
    var ww = window.innerWidth;
    var hh = window.innerHeight;
    if(imgWidth > ww || imgHeight > hh) {
        // 以宽作为基准来缩放
        if( (imgWidth/imgHeight - ww/hh) >= 0 ) {

            imgHeight =1*ww*imgHeight/imgWidth;
            imgWidth = 1*ww;
            // 以高为基准来缩放
        }else{
            imgWidth = 1*hh*imgWidth/imgHeight;
            imgHeight = 1*hh;
        }
    }

    var s = "<div class='bigimg'  onclick='$(this).remove()' style='position:fixed;width:"+ww+"px;height:"+hh+"px;background-color:rgba(0,0,0,0.8);left:0px;top:0px;background-image:url("+src+");background-size:"+imgWidth+"px "+imgHeight+"px;background-position:center;background-repeat:no-repeat;z-index:9999' ></div>";
    // 移除测试的img
    $(".tempImg").remove();
    $("body").append(s);
    // 添加滑动事件
    $(".bigimg").bind("mousewheel",function(e){
        // 向上滚动
        if( e.originalEvent.wheelDelta > 0 ){
            if( imgHeight > 3000 || imgWidth > 3000 ) return false;
            imgWidth += imgWidth*0.2;
            imgHeight += imgHeight*0.2;
            $(".bigimg").css("background-size",imgWidth+"px "+imgHeight+"px")
            // 向下滚动
        }else{
            if( imgHeight < 100 || imgWidth < 100 ) return false;
            imgWidth -= imgWidth*0.2;
            imgHeight -= imgHeight*0.2;

            $(".bigimg").css("background-size",imgWidth+"px "+imgHeight+"px")
        }
        window.event.returnValue=false;
        return false;
    })
}

// ｕ阻止事件冒泡
function zuzhi(event) {

    event.stopPropagation();
}
// 打招呼
function zhaohu(userid) {
    $.post("/zhaohu",{"userid":userid},function(d){
        if( ajaxdata(d) ) {
            toast("发送成功");
        }
    })
}

$(function()
{
    var tophtml="<div id='izl_rmenu' class='izl-rmenu'><a href='http://wpa.qq.com/msgrd?v=3&uin=1102855547&site=qq&menu=yes' target='_blank'><div class='btn btn-phone'></div></a><div class='btn btn-top'></div></div>";
    $("#top").html(tophtml);
    $("#izl_rmenu").each(function()
    {
        $(this).find(".btn-phone").mouseenter(function()
        {
            $(this).find(".phone").fadeIn("fast");
        });
        $(this).find(".btn-phone").mouseleave(function()
        {
            $(this).find(".phone").fadeOut("fast");
        });
        $(this).find(".btn-top").click(function()
        {
            $("html, body").animate({
                "scroll-top":0
            },"fast");
        });
    });
    var lastRmenuStatus=false;
    $(window).scroll(function()
    {
        var _top=$(window).scrollTop();
        if(_top>200)
        {
            $("#izl_rmenu").data("expanded",true);
        }
        else
        {
            $("#izl_rmenu").data("expanded",false);
        }
        if($("#izl_rmenu").data("expanded")!=lastRmenuStatus)
        {
            lastRmenuStatus=$("#izl_rmenu").data("expanded");
            if(lastRmenuStatus)
            {
                $("#izl_rmenu .btn-top").slideDown();
            }
            else
            {
                $("#izl_rmenu .btn-top").slideUp();
            }
        }
    });
});

function payment(that,order_id,type) {
    if( that ) {
        order_id = $(that).attr("order_id");
        type = $(that).attr("type");
    }
    window.order_id = order_id;
    window.type = type;
    // weixin
    if( is_weixn() ) {
        $("input[name=order_id]").val(order_id);
        $("input[name=type]").val(type);
        $("#wechatlink").attr("href","javascript:void(0)");
        $("#wechatlink").removeAttr("onclick");
        $("#wechatlink").click(function(){
            // $('#payfooter').css('display','block');
            $('#paybox').modal('hide');
            $("#wxpayform").submit();
        });
	$($(".payimg").find("p")[0]).remove();
    }else{
        $.post("/openpayment/wxpay_wap.php",{
            "order_id":window.order_id,
            "type":type
        },function(d){
            $("#wechatlink").attr("href",d);
        })
    }


    // 支付宝
    $("#WIDout_trade_no").val((new Date()).getTime() + "__" + order_id + "__" + type);
    $("#WIDsubject").val("成都徒哪儿户外网");
    $("#WIDtotal_amount").val($(that).attr("p")*$(that).attr("num"));
    $("#WIDbody").val("成都徒哪儿户外网");

    $('#paybox').modal('show');
}

function createpay(way) {
    switch(way){
        case "wxpay_wap":
            $.post("/openpayment/wxpay_wap.php",{
                "order_id":window.order_id,
                "type":type
            },function(d){
                // alert(d);
                $('#payfooter').css('display','block');
                location.href=d;
            })
            break;
    }
}

function is_weixn(){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
        return true;
    } else {
        return false;
    }
}

function img3big(t) {
    var src = '';
    // 不管是 div背景  还是 图片都能获取到图片 url
    if( t.nodeName == 'IMG' || t.nodeName == 'img' ) {
        src = $(t).attr('src').replace("\"",'');
    }else{
        var k = $(t).css("background-image").replace(/\"/g, "").split('(').pop();
        src = ""+k.substr(0,k.length-1);
    }
    var arr = src.split("/");
    var imgs = arr.pop();
    var imgarr = imgs.split("#");
    var imgpath = arr.join("/");
    var lis = "";
    // console.log(t); return;
    for( var i=0;i<imgarr.length;i++ ){
        var Item = "<li class=\"col-xs-6 col-sm-4 col-md-3\" data-src="+imgpath+"/"+imgarr[i]+" data-sub-html=\"<p>"+($(t).attr('title')==undefined?"":$(t).attr('title'))+"</p>\"></li>";
        lis+=Item;
    }

    var node = "<ul id=\"lightgallery\" class=\"list-unstyled row\">"+lis+"</ul>";
    $("#lightgallery").remove();
    $("body").append(node);
    $('#lightgallery').lightGallery();
    $($("#lightgallery li")[0]).trigger('click');
}