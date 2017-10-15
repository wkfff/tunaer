@extends("web.common")
@section("title","跳转中...")
@section("css")
@stop

@section("body")
    @include("web.header")
    <div class="content">

        <h1>正在检测用户身份，请勿操作，等待自动跳转．．．</h1>
    </div>

    @include("web.footer")
@stop

@section("htmlend")
    <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101428001" data-redirecturi="http://cdtunaer.com/qqlogin" charset="utf-8"></script>
    <script type="text/javascript">
        if( QC.Login.check() ) {
            QC.Login.getMe(function(openId, accessToken){
                otherlogin(openid);
            })
        }

    </script>
@stop