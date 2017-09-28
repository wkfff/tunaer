@extends("web.common")
@section("title","{$data->title}")

@section("css")
    <style>
        .tuijian{
            float:left;width:400px;height:100px;border:1px solid #eee;padding:10px;border-left:0px;
        }
        .tuwen{
            text-align: center;width:1200px;float:left;margin-top:30px;padding:10px;
            text-align: center;
        }
        .tuwen img{
            max-width:100% !important;
        }


    </style>
@stop
@section("body")
    @include("web.header")
    <div class="content">

        <div class="tuwen">
            {!! $data->content !!}
        </div>
        <div style="clear:both" ></div>

    </div>
    @include("web.footer")

@stop

@section("htmlend")
    <script>

    </script>
@stop
