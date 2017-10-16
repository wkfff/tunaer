<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>register</title>
</head>
<body>
    <div class="registerbox">
        <div class="title">注册新账号</div>
        <input type="text" name="phone" placeholder="请输入手机号码" value="">

        <input style="display:inline-block;width:130px;" name="code" type="text" placeholder="请输入手机验证码" value="" >
        <span id="sended" style="font-size: 12px;color:#F05050;display: none" >已发送，请注意查收</span>
        <button id="sendcodebtn" style="border:none;cursor:pointer;background-color: #00D8C9;color:white;border-radius:15px;font-size:0.9em;width:70px;height:30px;margin-left: 30px;opacity: 0.8;">发送</button>
        <input type="password" name="passwd" placeholder="登录密码" value="">

        <input id="submit" type="button" style="background: #00D8C9;border-radius:20px;color:#FFF;text-align: center;" value="注册">
        <!-- <p class="register_terms">登录即代表你同意<a target="_blank" href="#">《似友服务条款》</a>和<a target="_blank" href="#">《隐私条款》</a> </p> -->
        <div class="register_line" ></div>
        <div class="qrcode">
            <img src="/web/images/1506587848.png" alt="">
            <div>扫描浏览手机版</div>
            <button onclick="window.parent.location.href='https://graph.qq.com/oauth/show?which=Login&display=pc&client_id=101428001&response_type=token&scope=all&redirect_uri=http%3A%2F%2Fcdtunaer.com%2Fqqlogin'" style="background:#DC7164;cursor:pointer;">QQ登录</button>
            <button  style="background:#5DDF78;cursor: not-allowed;">微信登录</button>
        </div>

        <div onclick="window.parent.closereg()" class="register_close"></div>
    </div>
</body>
</html>
<script src="/web/js/jquery.min.js" ></script>
<script>

    $("#sendcodebtn").click(function(){
        var phone = $.trim( $(".registerbox input[name='phone']").val() );
        var r = /^1[23456789]{1}\d{9}$/;
        if( !r.test(phone) ) {
            window.parent.toast("手机格式错误"); return false;
        }
        $.post("/sendcode",{'phone':phone,'_token':"{{csrf_token()}}"},function(data){
            var res = window.parent.ajaxdata(data);
            $("#sendcodebtn").css("display","none");
            $("#sended").css("display",'inline');
        })
    })
    $(".registerbox #submit").click(function(){
        var phone = $.trim( $(".registerbox input[name='phone']").val() );
        var passwd = $.trim( $(".registerbox input[name='passwd']").val() );
        var code = $.trim( $(".registerbox input[name='code']").val() );
        $.post("/register",{
            "phone":phone,
            "passwd":passwd,
            "code":code
        },function(data){

            var res = window.parent.ajaxdata(data);
            if( res ) {
                localStorage.setItem("login_token",res);
                if( localStorage.getItem("enterurl") ) {
                    if( window.parent.location.href==localStorage.getItem("enterurl") ) {
                        window.parent.location.reload();
                    }else{
                        window.parent.location.href= localStorage.getItem("enterurl");
                    }
                }else{
                    window.parent.location.reload();
                }
            }
        })
    })
</script>

<style>
    *{
        margin:0px;padding:0px;outline:none;
    }
    body{
        overflow:hidden;
    }
    .register_line{
        background: #00D8C9;
        width:1px;
        height:300px;
        position: absolute;
        top:45px;
        left:340px;
    }
    .register_close:hover {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .register_close {
        background-image: url(/web/images/icon.png);
        position: absolute;
        top: 40px;
        right: 60px;
        width: 18px;
        height: 18px;
        background-position: -2px -190px;
        cursor: pointer;
        -webkit-transition: .2s all ease-in-out;
        -moz-transition: .2s all ease-in-out;
        -o-transition: .2s all ease-in-out;
        transition: .2s all ease-in-out;
    }
    .registerbox a {
        color: #00D8C9;
        text-decoration: none;
    }
    .registerbox .verify {
        height: 40px;
    }
    .registerbox .qrcode div {
        width: 270px;
        text-align: center;
        color: #546064;
        /*font-size: 0.9em;*/
    }
    .registerbox .qrcode button {
        background: #00D8C9;
        color: #FFF;
        margin: 0;
        padding: 0;
        border: 0;
        border-radius: 20px;
        width: 200px;
        height: 35px;
        margin-top: 20px;
        margin-left: 35px;
    }
    .registerbox .qrcode img {
        width: 154px;
        /*height: 154px;*/
        margin-top: 30px;
        opacity: 0.8;
        margin-left: 55px;
    }
    .registerbox .qrcode {
        width: 270px;
        height: 360px;
        /*background: #000;*/
        position: absolute;
        left: 330px;
        top: 20px;
        /*border-left: 1px solid #00D8C9;*/
    }
    .registerbox p {
        font-size: 10px;
        color: #B3C1C6;
        text-align: center;
        width: 300px;
    }
    .registerbox .title {
        width: 300px;
        text-align: center;
        color: #546064;
        font-size: 1.1em;
        line-height: 40px;
        margin-bottom: -10px;
        margin-top: 30px;
    }
    .registerbox input {
        width: 250px;
        height: 35px;
        display: block;
        border: none;
        margin: 0;
        padding: 0;
        border-bottom: 1px solid #DDD;
        text-align: left;
        margin-top: 30px;
        margin-left: 25px;
        /*font-size:1.1em;*/
    }
    .registerbox {
        width: 600px;
        height: 360px;
        background: #fff;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -300px;
        margin-top: -200px;
        box-shadow: 0 5px 16px rgba(0, 0, 0, 0.8);
        border-radius: 4px;
        padding: 20px;
    }
</style>