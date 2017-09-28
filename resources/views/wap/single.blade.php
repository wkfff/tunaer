@extends("wap.common")
@section("title","{$data->title}")
@section("css")

    <style>
        .tubuitem{
            width:99%;height:200px;background-size:cover;margin:0 auto;
            background-position:center;
            background-repeat:no-repeat;margin-top:7.5px;
            /*display: inline-block;*/
            position: relative;
        }
        .tuwen{
            font-size:1em !important;width:100%;padding:10px;
            overflow: hidden;margin-top:10px;display:none;
        }
        .tuwen img{
            max-width:100% !important;height:auto !important;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #eee;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        <span style="max-width:180px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;line-height:55px;">{{$data->title}}</span>
    </div>
    <div class="content" style="margin-top:55px;" >

        <div class="tuwen">
            {!! $data->content !!}
        </div>


    </div>

    @include("wap.footer")

@stop
@section("htmlend")
    <script>
        $(document).ready(function () {
            $(".tuwen").find("*").css("width","auto");
            $(".tuwen").find("img").css("margin","5px 0");
            $(".tuwen").find("div").css({
                "padding":"0",
                "margin":"0",
            });
            $(".tuwen").css("display","block");
        });


    </script>

@stop