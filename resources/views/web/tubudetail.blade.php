@extends("web.common")
@section("title",$detail->title)
@section("css")
    <link rel="stylesheet" href="/web/css/index.css">
@stop

@section("body")
    @include("web.header")

    @include("web.footer")

@stop

@section("js")
    <script type='text/javascript' src="/web/js/index.js" ></script>
@stop