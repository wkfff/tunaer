@extends("web.common")
@section("title","徒步商城")
@section("css")
    <style>
        .toppic{
            width:100%;height:335px;background-size:cover;background-position:center;background-repeat: no-repeat;
            position: relative;
        }
    </style>
@stop

@section("body")
    @include("web.header")
    <div class="toppic" style="background-image: url(/admin/data/images/1505009109.jpg);" >
    </div>
    <div class="content">
        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>
            <a style="color: #999;" href="/member/list" >徒步商城</a>
        </div>

        <div style="clear:both" ></div>
        {!! $fenye !!}

    </div>
    @include("web.footer")

@stop
@section("htmlend")

@stop
