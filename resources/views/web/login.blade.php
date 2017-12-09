<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
</head>
<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101428001" data-redirecturi="http://cdtunaer.com/qqlogin" charset="utf-8"></script>

<body>
<div class="loginbox">
    <div class="title">登录徒哪儿网</div>

    <input name="phone" type="text" placeholder="请输入手机号码" value="">
    <input name="passwd" type="password" placeholder="登录密码" value="">
    <input name="code" style="display:inline-block;width:150px;" value="" type="text" placeholder="请输入图形验证码">
    <img class="verify" src="/verifycode" alt="" >
    <input type="button" id="submit" style="background: #00D8C9;border-radius:20px;color:#FFF;text-align: center;" value="登录">
    <p style="text-align:center;margin-top:10px" ><a href="/forgetpassword" target="_blank" style="color:#444;font-size:14px;">忘记密码？</a></p>
    <div class="login_line" ></div>
    <div class="qrcode">
        <img src="/web/images/1506587848.png" alt="">
        <div>扫描浏览手机版</div>
        <button onclick="window.parent.location.href='https://graph.qq.com/oauth/show?which=Login&display=pc&client_id=101428001&response_type=token&scope=all&redirect_uri=http%3A%2F%2Fcdtunaer.com%2Fqqlogin'" style="background:#DC7164;cursor:pointer;">QQ登录</button>
        <button onclick="alert('请用微信扫描上方二维码')"  style="background:#5DDF78;">微信登录</button>
    </div>

    <div class="register_close" onclick="window.parent.closelogin()"></div>
</div>
</div>
</body>
</html>
<script src="/web/js/jquery.min.js" ></script>
<script>

    $(".verify").click(function(e){
        $(".verify").attr("src","/verifycode?t="+(new Date().getTime()));
    })

    $(".loginbox #submit").click(function(){
        var phone = $.trim( $(".loginbox input[name='phone']").val() );
        var passwd = $.trim( $(".loginbox input[name='passwd']").val() );
        var code = $.trim( $(".loginbox input[name='code']").val() );
        $.post("/login",{
            "phone":phone,
            "passwd":passwd,
            "verifycode":code
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
        margin:0px;padding:0px;
        outline:none;
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
    .loginbox a {
        color: #00D8C9;
        text-decoration: none;
    }
    .loginbox .verify {
        height: 40px;
    }
    .loginbox .qrcode div {
        width: 270px;
        text-align: center;
        color: #546064;
        /*font-size: 0.9em;*/
    }
    .loginbox .qrcode button {
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
    .loginbox .qrcode img {
        width: 154px;
        /*height: 154px;*/
        margin-top: 30px;
        opacity: 0.8;
        margin-left: 55px;
    }
    .loginbox .qrcode {
        width: 270px;
        height: 360px;
        /*background: #000;*/
        position: absolute;
        left: 330px;
        top: 20px;
        /*border-left: 1px solid #00D8C9;*/
    }
    .loginbox p {
        font-size: 10px;
        color: #B3C1C6;
        text-align: center;
        width: 300px;
    }
    .loginbox .title {
        width: 300px;
        text-align: center;
        color: #546064;
        font-size: 1.1em;
        line-height: 40px;
        margin-bottom: -10px;
        margin-top: 30px;
    }
    .loginbox input {
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
    .loginbox {
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