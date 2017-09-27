@extends("wap.common")
@section("title","登录")
@section("css")

@stop

@section("body")
    <div onclick="window.parent.closelogin()" style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span style="position: absolute;right:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-remove" ></span>
        <span>注册新用户</span>
    </div>
    <div class="content" style="margin-top:55px;" >
        <div style="padding:20px;">
            <div class="form-group">
                <label>手机号</label>
                <input style="height:40px;" name="phone" type="number" class="form-control"  placeholder="手机号码">
            </div>
            <div class="form-group">
                <label style="display: block">手机验证码</label>
                <input name="code" style="height:40px;width:50%;float:left" type="text" class="form-control"  placeholder="登录密码">
                <button id="sendcodebtn" onclick="sendcode()" style="float:left;margin-left:10px;height:40px;" class="btn btn-default">点击发送</button>
            </div>
            <div style="clear:both;height:15px;width:100%;" ></div>
            <div class="form-group">
                <label>密码</label>
                <input style="height:40px;" name="passwd" type="password" class="form-control"  placeholder="登录密码">
            </div>

            <button type="button" onclick="reg()" style="width:100%;height:40px;background-color:#337ab7" class="btn btn-primary ">登录</button>
        </div>
        <div style="text-align:center" ><a href="/login">已有帐号登录</a></div>
    </div>

    {{--    @include("wap.footer")--}}


@stop

@section("htmlend")

    <script>
        function sendcode() {
            var phone = $.trim( $("input[name='phone']").val() );
            var r = /^1[23456789]{1}\d{9}$/;
            if( !r.test(phone) ) {
                window.parent.toast("手机格式错误"); return false;
            }
            $.post("/sendcode",{'phone':phone},function(data){
                var res = window.parent.ajaxdata(data);
                $("#sendcodebtn").removeAttr("onclick");
                $("#sendcodebtn").text("已发送");
                toast("发送成功，请注意查收");
            })
        }
        function reg() {
            var phone = $.trim( $(" input[name='phone']").val() );
            var passwd = $.trim( $(" input[name='passwd']").val() );
            var code = $.trim( $(" input[name='code']").val() );
            $.post("/register",{
                "phone":phone,
                "passwd":passwd,
                "code":code
            },function(data){

                var res = window.parent.ajaxdata(data);
                if( res ) {
                    window.parent.toast("注册成功");
                    window.parent.location.reload();
                }
            })
        }
    </script>
@stop