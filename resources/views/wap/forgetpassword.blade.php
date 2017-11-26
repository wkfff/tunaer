@extends("wap.common")
@section("title","找回密码")
@section("css")


@stop

@section("body")

    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        {{--<span data-toggle="modal" data-target="#myModal2" style="float:left;position: absolute;right:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-search" ></span>--}}
        <span>找回密码</span>
    </div>
    <div class="content" style="margin-top:70px;width:90%;" >

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