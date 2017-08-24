<div class="register_bg">
    <div class="registerbox">
        <div class="title">注册新账号</div>
        <input type="text" name="phone" placeholder="请输入手机号码" value="18328402805">

        <input style="display:inline-block;width:130px;" name="code" type="text" placeholder="请输入手机验证码" value="123456" >
        <span id="sended" style="font-size: 12px;color:#F05050;display: none" >已发送，请注意查收</span>
        <button id="sendcodebtn" style="border:none;cursor:pointer;background-color: #00D8C9;color:white;border-radius:15px;font-size:0.9em;width:70px;height:30px;margin-left: 30px;opacity: 0.8;">发送</button>
        <input type="password" name="passwd" placeholder="登录密码" value="123456">

        <input id="submit" type="button" style="background: #00D8C9;border-radius:20px;color:#FFF;text-align: center;" value="注册">
        <p class="register_terms">登录即代表你同意<a target="_blank" href="#">《似友服务条款》</a>和<a target="_blank" href="#">《隐私条款》</a> </p>
        <div class="register_line" ></div>
        <div class="qrcode">
            <img src="/image/qrcode.png" alt="">
            <div>扫描下载似友APP</div>
            <button style="background:#DC7164">新浪微博登录</button>
            <button style="background:#5DDF78">微信登录</button>
        </div>

        <div class="register_close"></div>
    </div>
</div>


<script>
    $(".login_close").click(function () {
        $(".login_bg").css("display", "none");
        $("body").css("overflow","auto");
    })
    $("#sendcodebtn").click(function(){
        var phone = $.trim( $(".registerbox input[name='phone']").val() );
        var r = /^1[34578]{1}\d{9}$/;
        if( !r.test(phone) )
        {
            ialert("手机格式错误",1); return false;
        }
        $.post("{{url('ajax/sendcode')}}",{'phone':phone,'_token':"{{csrf_token()}}"},function(data){
            var res = checkajaxdata(data);
            if( res )
            {
                $("#sendcodebtn").css("display","none");
                $("#sended").css("display",'inline');
            }
        })
    })
    $(".registerbox #submit").click(function(){
        var phone = $.trim( $(".registerbox input[name='phone']").val() );
        var passwd = $.trim( $(".registerbox input[name='passwd']").val() );
        var code = $.trim( $(".registerbox input[name='code']").val() );
        $.post("{{url('ajax/register')}}",{
            "phone":phone,
            "passwd":passwd,
            "code":code,
            "_token":"{{csrf_token()}}"
        },function(data){
            var res = checkajaxdata(data);
            if( res )
            {
                setTimeout(function(){
                    location.href="{{url('main')}}";
                },1000)
            }
        })
    })
</script>

<style>
    .register_bg {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
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
        background-image: url(../image/icon.png);
        position: absolute;
        top: 20px;
        right: 20px;
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
        left: 350px;
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