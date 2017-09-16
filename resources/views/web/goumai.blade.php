@extends("web.common")
@section("title",$data->title)
@section("css")
    <style>
        .searchb{
            width:140px;height:40px;border:none; border: 1px solid #FF0036;font-size:16px;
            letter-spacing: 4px; background:#ffeded;color: #FF0036;
            margin-right:20px;outline:none;
        }
        .searchb:active{
            opacity:0.7;color:#fff
        }
    </style>
@stop

@section("body")
    @include("web.header")
    <div class="content">

        <div style="height:220px;margin-top:20px;padding:10px;border:1px solid #ddd;" >
            <div style="height:200px;width:200px;background: dodgerblue;float:left;background-image:url(/admin/data/images/{{$data->pictures}});background-size:cover;background-position:center" ></div>
            <div style="height:200px;width:950px;;line-height:30px;float:left;margin-left:20px;" >
                <div style="font-size:18px;" >{{$data->title}}</div>
                <div style="font-size:18px;" >尺寸：{{$chicun}}</div>
                <div style="font-size:18px;" >颜色：{{$color}}</div>
                <div style="font-size:18px;" >数量：{{$num}}</div>
            </div>
            <div style="clear:both" ></div>
        </div>
        <button onclick="addgouwuche()" class="searchb" style="background:#FF0036;color:#fff;float:right;margin-right:0px;margin-top:10px;"  ><span class="glyphicon glyphicon-yen" style="margin-right:5px;" ></span>去结算</button>
    </div>

    @include("web.footer")
@stop

@section("htmlend")

@stop