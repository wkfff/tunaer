
// 打开登陆框
function openlogion() {
    var iframe = `<div onclick="$(this).toggle();" id="loginbg" style="height:100%;width:100%;position:fixed;z-index:10;background:rgba(0,0,0,0.3);left:0px;top:0px;display:none" ><iframe src="/login" frameborder="0" style="width: 600px;height: 360px;background: #fff;position: absolute;left: 50%;top: 50%;margin-left: -300px;margin-top: -200px;box-shadow: 0 5px 16px rgba(0, 0, 0, 0.8);border-radius: 4px;z-index:1;"></iframe></div>`;
    $("body").append(iframe);
    setTimeout(function(){
        $("#loginbg").css("display","block");
    },100)
}
// 关闭登录框
function closelogin() {
    $("#loginbg").remove();
}
// 打开登陆框
function openreg() {
    var iframe = `<div onclick="$(this).toggle();" id="regbg" style="height:100%;width:100%;position:fixed;z-index:10;background:rgba(0,0,0,0.3);left:0px;top:0px;display:none" ><iframe src="/register" frameborder="0" style="width: 600px;height: 360px;background: #fff;position: absolute;left: 50%;top: 50%;margin-left: -300px;margin-top: -200px;box-shadow: 0 5px 16px rgba(0, 0, 0, 0.8);border-radius: 4px;z-index:1;"></iframe></div>`;
    $("body").append(iframe);
    setTimeout(function(){
        $("#regbg").css("display","block");
    },100)
}
// 关闭登录框
function closereg() {
    $("#regbg").remove();
}
// 吐丝提示
function toast(title,time=2000) {
    $(".toast").remove();
    clearTimeout(window.toastst);
    var tmp = "<div style='height:0px;width:100%;position:fixed;left:0px;bottom:250px;;text-align:center;line-height:50px;z-index:20' class='toast'><span style='background:#194C8E;color:#fff;padding:14px 30px;border-radius:10px;font-size:16px;font-weight:bold'>"+title+"</span></div>";
    $("body").append(tmp);
    window.toastst = setTimeout(function(){
        $(".toast").fadeOut(1000);
    },time)
}
// 过滤ajax数据
function ajaxdata(data) {
    var qianzhui = data.substr(0,3);

    switch(qianzhui) {
        case "400":
            toast(data.substr(4)); return false;
        case "200":
            toast(data.substr(4)); return true;
    }
    switch(data) {
        case "":
            return false;
        case "nologin":
            openlogion();return false;
        case "noaccess":
            toast("access deny"); return false;
    }
    return JSON.parse(data);
}
