@extends("web.common")
@section("title","跳转中...")
@section("css")
@stop

@section("body")
    @include("web.header")
    <div class="content">

        <h1>正在检测用户身份，请勿操作，等待自动跳转．．．</h1>
    </div>
    <div class="modal fade" id="qqlogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:100%">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <div style="padding:20px;">
                        <div class="form-group">
                            <label>帐号</label>
                            <input style="height:40px;" name="ql-phone" type="number" class="form-control"  placeholder="手机号码">
                        </div>
                        <div class="form-group">
                            <label>密码</label>
                            <input style="height:40px;" name="ql-passwd" type="password" class="form-control"  placeholder="登录密码">
                        </div>
                        <div style="clear:both;height:20px;width:100%;" ></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="ql_login()" style="width:100%;height:40px;background-color:#337ab7" class="btn btn-primary ">完成</button>
                </div>
            </div>
        </div>
    </div>
    @include("web.footer")
@stop

@section("htmlend")
    <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101428001" data-redirecturi="http://cdtunaer.com/qqlogin" charset="utf-8"></script>
    <script type="text/javascript">
        if( QC.Login.check() ) {
            QC.Login.getMe(function(openId, accessToken){
                localStorage.setItem("qq_access_token",accessToken);
                localStorage.setItem("qq_openid",openId);
                otherlogin(openId,"qq");
            })
        }

    </script>
@stop