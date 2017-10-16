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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">用户登录</h4>
            </div>
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
                </div>
            </div>
            <div class="modal-footer">
                <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101428001" data-redirecturi="http://cdtunaer.com/qqlogin" charset="utf-8"></script>

                <div style="text-align:left" >
                    <a href="javascript:void(0)" style="float:right;" onclick="openreg()">注册新用户</a>
                    <span id="qqLoginBtn"></span>
                </div>
                <script type="text/javascript">
                    QC.Login({
                        btnId:"qqLoginBtn"    //插入按钮的节点id
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="regmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:100%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">注册新用户</h4>
            </div>
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

                    <button type="button" onclick="rg_register()" style="width:100%;height:40px;background-color:#337ab7" class="btn btn-primary ">登录</button>
                </div>
            </div>
            <div class="modal-footer">
                <div style="text-align:center" ><a href="javascript:void(0)" onclick="openlogion()">已有帐号登录</a></div>
            </div>
        </div>
    </div>
</div>
@yield("body","")

</body>

</html>
@yield("htmlend","")