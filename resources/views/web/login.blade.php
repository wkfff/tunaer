<div class="login_bg">
    <div class="loginbox">
        <div class="title">登录似友</div>

            <input name="phone" type="text" placeholder="请输入手机号码" value="18328402805">
            <input name="passwd" type="password" placeholder="登录密码" value="123456">
            <input name="_token" type="hidden"  value="{{csrf_token()}}">
            <input name="code" style="display:inline-block;width:150px;" value="" type="text" placeholder="请输入图形验证码">
            <img class="verify" src="{{url('verifycode')}}" alt="" >
            <input type="button" id="submit" style="background: #00D8C9;border-radius:20px;color:#FFF;text-align: center;" value="登录">

        <p class="login_terms">登录即代表你同意<a target="_blank" href="#">《似友服务条款》</a>和<a target="_blank" href="#">《隐私条款》</a> </p>
        <div class="login_line" ></div>
        <div class="qrcode">
            <img src="/image/qrcode.png" alt="">
            <div>扫描下载似友APP</div>
            <button style="background:#DC7164">新浪微博登录</button>
            <button style="background:#5DDF78">微信登录</button>
        </div>

        <div class="login_close"></div>
    </div>
</div>


<script>
    $(".login_close").click(function () {
        $(".login_bg").css("display", "none");
        $("body").css("overflow","auto");
    })
    $(".verify").click(function(e){
        $(".verify").attr("src","/verifycode?t="+(new Date().getTime()));
    })
    $(".loginbox #submit").click(function(){
        var phone = $.trim( $(".loginbox input[name='phone']").val() );
        var passwd = $.trim( $(".loginbox input[name='passwd']").val() );
        var code = $.trim( $(".loginbox input[name='code']").val() );
        $.post("{{url('ajax/login')}}",{
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
    .login_bg {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }
    .login_line{
        background: #00D8C9;
        width:1px;
        height:300px;
        position: absolute;
        top:45px;
        left:340px;
    }
    .login_close:hover {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .login_close {
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
        left: 350px;
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