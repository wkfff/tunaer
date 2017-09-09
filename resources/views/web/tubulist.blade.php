@extends("web.common")

@section("css")
    <link rel="stylesheet" href="/web/css/index.css">
@stop

@section("body")
    @include("web.header")
    <style>
        .toppic{
            width:100%;height:335px;background-size:cover;background-position:center;background-repeat: no-repeat;
            position: relative;
        }
        .left{
            width:895px;float:left;
        }
        .right{
            width:300px;height:300px;float:right;border:1px solid #ccc;
        }
        .tubuitem{
            width:860px;height:230px;margin-bottom:20px;
            position: relative;border:1px solid #ccc;
        }
        .head{
            background-size:cover;background-position: center;;
            background-repeat:no-repeat;
        }
    </style>
    <div class="toppic" style="background-image: url(/admin/data/images/{{ count($list) == 0 ? '#' : $list[0]->pics}});" >
        @if(count($list) == 0)
            <div class='content'>
                <p style="font-size:20px;color:#999;margin-top:20px" >没有相关活动</p>
            </div>
        @endif
    </div>
    <div class="content">
        <div class="pics" ></div>
        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>
            <a style="color: #999;" href="/member/list" >{{$list[0]->name }}</a>
        </div>
            <div class="left">
                @for( $i=0;$i<count($list);$i++ )
                <div class="tubuitem">
                    <div class="head" style="margin:10px;width:300px;height:200px;float:left;background-image:url(/admin/data/images/{{$list[$i]->pictures}})" ></div>
                    <div style="margin:10px;width:500px;height:200px;float:left" >
                        <div style="color:#4b8ee8;font-size:20px;">
                            {{$list[$i]->title}}
                        </div>
                    </div>
                </div>
                @endfor
            </div>
            <div class="right">

            </div>

    </div>
    <div style="clear:both" ></div>
    @include("web.footer")

@stop
