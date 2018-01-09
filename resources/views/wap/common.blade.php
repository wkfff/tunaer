<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield("meta","")
    {{--<meta name="theme-color" content="#e83888">--}}
    <link rel="shortcut icon" type="image/x-icon" href="/web/images/ico.png">
    <link rel="stylesheet" href="/web/css/bootstrap.min.css">
    <link rel="stylesheet" href="/wap/css/common.css">

    @yield("css","")

    <title>@yield("title","徒哪儿")</title>
    <script src="/web/js/jquery.min.js" ></script>
    <script src="/web/js/bootstrap.min.js" ></script>
    <script src="/wap/js/common.js" ></script>
    <script>
        if( location.host == "cdtunaer.com" ) {
            location.href = location.href.replace("cdtunaer.com","www.cdtunaer.com");
        }
    </script>
    @if( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && $_SERVER['REMOTE_ADDR'] == '183.222.50.199' )
        <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" ></script>
        <script>
            alert('...');
            wx.config("{{getsignature()}}");
            wx.ready(function(){
            });
            wx.error(function(res){
            });
            wx.onMenuShareTimeline({
                title: document.title,
                link: location.href,
                imgUrl: 'http://www.cdtunaer.com/web/images/admin.png',
                success: function () { },
                cancel: function () { }
            });
            wx.onMenuShareAppMessage({
                title: document.title,
                link: location.href,
                desc: '徒哪儿户外俱乐部邀请大家参加徒步活动，健康徒步，有氧运动，让户外更加精彩。点击即可报名',
                imgUrl: 'http://www.cdtunaer.com/web/images/admin.png',
                type: '',
                dataUrl: '',
                success: function () { },
                cancel: function () { }
            });
        </script>
    @endif
</head>
<body >

@if( !Session::get('uid') )
    <script>
        if( localStorage.getItem("login_token") ) {
            var token = localStorage.getItem("login_token");
            $.post("/tokenlogin",{"token":token},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }else{
                    localStorage.removeItem("login_token");
                }
            })
        }
    </script>
@endif



<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:100%">
            {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span></button>--}}
                {{--<h4 class="modal-title" id="myModalLabel">用户登录</h4>--}}
            {{--</div>--}}
            <div class="modal-body">
                <div style="padding:20px;">
                    <div class="form-group">
                        <label>帐号</label>
                        <input style="height:40px;" name="lg-phone" type="number" class="form-control"  placeholder="手机号码">
                    </div>
                    <div class="form-group">
                        <label>密码</label>
                        <input style="height:40px;" name="lg-passwd" type="password" class="form-control"  placeholder="登录密码">
                    </div>
                    <div class="form-group">
                        <label style="display: block">图形验证码</label>
                        <input name="lg-code" style="height:40px;width:50%;float:left" type="text" class="form-control"  placeholder="登录密码">
                        <img onclick="$(this).attr('src','/verifycode?t='+(new Date().getTime()));" style="float:left;margin-left:10px;" src="/verifycode" alt="" >
                    </div>
                    <div style="clear:both;height:20px;width:100%;" ></div>
                    <button type="button" onclick="lg_login()" style="width:100%;height:40px;background-color:#337ab7" class="btn btn-primary ">登录</button>
                    <p style="text-align:center;margin-top:10px" ><a href="/forgetpassword" target="_blank" style="color:#444;font-size:14px;">忘记密码？</a></p>
                </div>
                <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101428001" data-redirecturi="http://cdtunaer.com/qqlogin" charset="utf-8"></script>
                <div style="text-align:left" >
                    <a href="javascript:void(0)" style="float:right;line-height:25px;" onclick="openreg()">注册新用户</a>
                    <a href="javascript:void(0)" onclick="openQQ()" style="float:left;height:25px;width:80px;background:#007BBD;color:white;display: inline-block;text-align:center;line-height:25px;border-radius:5px;" >QQ登录</a>
                    <span id="qqLoginBtn" style="float:left;"></span>
                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx10106332de6f9840&redirect_uri=http://www.cdtunaer.com/wxlogin&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" style="float:left;margin-left:10px;height:25px;width:80px;background:#5DDF78;color:white;display: inline-block;text-align:center;line-height:25px;border-radius:5px;" >微信登录</a>

                </div>
                <script type="text/javascript">
                    function openQQ() {
                        QC.Login.showPopup({
                            appId:"101428001",
                            redirectURI:"http://cdtunaer.com/qqlogin"
                        });
                    }
                </script>
            </div>
            <div class="modal-footer" style="opacity: 0;">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="regmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:100%">
            {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span></button>--}}
                {{--<h4 class="modal-title" id="myModalLabel">注册新用户</h4>--}}
            {{--</div>--}}
            <div class="modal-body">
                <div style="padding:20px;">
                    <div class="form-group">
                        <label>手机号</label>
                        <input style="height:40px;" name="rg-phone" type="number" class="form-control"  placeholder="手机号码">
                    </div>
                    <div class="form-group">
                        <label style="display: block">手机验证码</label>
                        <input name="rg-code" style="height:40px;width:50%;float:left" type="text" class="form-control"  placeholder="登录密码">
                        <button onclick="sendcode()" style="float:left;margin-left:10px;height:40px;" class="btn btn-default sendcodebtn">点击发送</button>
                    </div>
                    <div style="clear:both;height:15px;width:100%;" ></div>
                    <div class="form-group">
                        <label>密码</label>
                        <input style="height:40px;" name="rg-passwd" type="password" class="form-control"  placeholder="登录密码">
                    </div>

                    <button type="button" onclick="rg_register()" style="width:100%;height:40px;background-color:#337ab7" class="btn btn-primary ">立即注册</button>
                </div>
            </div>
            <div class="modal-footer">
                <div style="text-align:center" >
                    <a href="javascript:void(0)" style="float:right;line-height:25px;" onclick="openlogion()">已有帐号登录</a>
                    <a href="javascript:void(0)" onclick="openQQ()" style="float:left;height:25px;width:80px;background:#007BBD;color:white;display: inline-block;text-align:center;line-height:25px;border-radius:5px;" >QQ登录</a>
                    <span id="qqLoginBtn" style="float:left;"></span>
                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx10106332de6f9840&redirect_uri=http://www.cdtunaer.com/wxlogin&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" style="float:left;margin-left:10px;height:25px;width:80px;background:#5DDF78;color:white;display: inline-block;text-align:center;line-height:25px;border-radius:5px;" >微信登录</a>
</div>
            </div>
        </div>
    </div>
</div>
@yield("body","")

</body>

</html>
@yield("htmlend","")