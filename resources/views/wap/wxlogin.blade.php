@extends("wap.common")
@section("title","跳转中...")
@section("css")
@stop

@section("body")
    @include("wap.header")
    <div class="content" style="margin-top:50px;">

        <p style="color:darkgrey;text-align: center;">正在检测用户身份．．．</p>
        {{$userinfo->openid}}
    </div>
    <div class="modal fade" id="wxlogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:100%">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">初次使用请绑定手机号</h4>
                </div>
                <div class="modal-body">
                    <div style="padding:20px;">
                        <div class="form-group">
                            <label>手机号</label>
                            <input style="height:40px;" name="ql-phone" type="number" class="form-control"  placeholder="手机号码">
                        </div>
                        <div class="form-group">
                            <label style="display: block">手机验证码</label>
                            <input name="ql-code" style="height:40px;width:50%;float:left" type="text" class="form-control"  placeholder="验证码">
                            <button onclick="sendcode2()" style="float:left;margin-left:10px;height:40px;" class="btn btn-default sendcodebtn">点击发送</button>
                        </div>
                        <div style="clear:both;height:15px;width:100%;" ></div>
                        <div class="form-group">
                            <label>密码</label>
                            <input style="height:40px;" name="ql-passwd" type="password" class="form-control"  placeholder="登录密码">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="ql_register()" style="width:100%;height:40px;background-color:#337ab7" class="btn btn-primary ">立即绑定</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section("htmlend")
    <script>
        $(document).ready(function(){
//            alert("1");
            {{--wxdata['nickname'] = "{{$userinfo->nickname}}";--}}
            {{--wxdata['gender'] = "{{$userinfo->sex=='1' ? '男':'女'}}";--}}
            {{--wxdata['year'] = "1990";--}}
            {{--wxdata['city'] = "{{$userinfo->country.'-'.$userinfo->province.'-'.$userinfo->city}}";--}}
            {{--wxdata['figureurl_qq_2'] = "{{$userinfo->headimgurl}}";--}}
//            localStorage.setItem('qqdata',JSON.stringify(wxdata));
            localStorage.setItem("wx_openid","{{$userinfo->openid}}");
            alert("3");
            $("#wxlogin").modal("show");
            otherlogin("{{$userinfo->openid}}","weixin");
            alert("4");
        });
    </script>
@stop