@extends("web.common")
@section("title","跳转中...")
@section("css")
@stop

@section("body")
    @include("web.header")
    <div class="content">

        跳转中．．．
    </div>

    @include("web.footer")
@stop

@section("htmlend")
    <script type="text/javascript"
            src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" charset="utf-8" data-callback="true"></script>
@stop