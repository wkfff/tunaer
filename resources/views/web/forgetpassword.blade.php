@extends("web.common")
@section("title","找回密码")
@section("css")


@stop

@section("body")
    @include("web.header")

    <div class="content" style="margin-top:50px;" >

        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>
            <a style="color: #999;" href="javascript:void(0)" onclick="location.reload();" >找回密码</a>
        </div>

        <div class="form-group">
            <label >手机号码 </label>
            <input class="form-control" type="text" value="" placeholder="手机号码" name="mobile"  >

        </div>
        <div class="form-group">
            <button type="button" id="sendcodebtn" onclick="sendcode()" class="btn btn-success">发送验证码</button></div>
        <div class="form-group">
            <label >手机验证码 </label>
            <input class="form-control" type="text" value="" placeholder="手机验证码" name="vcode"  >
        </div>
        <div class="form-group">
            <label >输入新密码 </label>
            <input class="form-control" type="text" value="" placeholder="输入新密码" name="newpasswd"  >
        </div>
        <div class="form-group">
            <button onclick="tijiao()" type="button" class="btn btn-primary">确认提交</button></div>
        <div style="height:70px;" ></div>

    </div>


@stop

@section("htmlend")

    <script>

        function sendcode() {
            var phone = $("input[name=mobile]").val();
            var r = /^1[23456789]{1}\d{9}$/;
            if( !r.test(phone) ) {
                toast("手机格式错误"); return false;
            }
            $.post("/sendcode",{'phone':phone},function(data){
                var res = ajaxdata(data);
                $("#sendcodebtn").text("已发送，请注意查收");
                $("#sendcodebtn").removeAttr("onclick");
            })
        }

        function tijiao() {
            var mobile = $("input[name=mobile]").val();
            var vcode = $("input[name=vcode]").val();
            var newpasswd = $("input[name=newpasswd]").val();
            $.post("/changepasswd",{
                "mobile":mobile,"vcode":vcode,"newpasswd":newpasswd
            },function(d){
                if(msg = ajaxdata(d)) {
                    toast(msg);
                    location.href="/";
                }
            })
        }

    </script>

@stop