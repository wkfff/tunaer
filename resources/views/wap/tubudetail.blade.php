@extends("wap.common")
{{--@section("title","徒友动态")--}}
@section("css")
    <link rel="stylesheet" href="/web/css/swiper-3.4.2.min.css">
    <style>
        .swiper-container {
            width: 99%;
            height: 200px;
            margin:0 auto;
            /*border-radius:3px;*/
            /*margin-top:50px;*/
        }
        .swiper-slide{
            background-size:cover;background-repeat:no-repeat;background-position:center;
            position: relative;
        }
        .swiper-pagination-bullet-active{
            background: #fff !important;
            border-radius:0px !important;
        }
        .swiper-pagination-bullet{
            border-radius:0px !important;
            width:10px !important;
            height:2px !important;
        }
        .swiper-pagination-bullets{
            text-align: right !important;
        }
        .tuwen{
            font-size:11px !important;width:100%;padding:10px;
            overflow: hidden;margin-top:20px;display:none;
        }
        .tuwen img{
            max-width:100% !important;height:auto !important;
        }
    </style>
@stop

@section("body")

    <div class="content">

        <div onclick="history.back()" style="width:40px;height:30px;background:rgba(0,0,0,0.3);color:#fff;position:fixed;left:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
            <span class="glyphicon glyphicon-menu-left" ></span>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @for( $imgs = explode("#",$detail->pictures),$i=0;$i<count($imgs);$i++ )
                    <div class="swiper-slide" style="background-image:url(/admin/data/images/{{$imgs[$i]}});">
                    </div>
                @endfor
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div style="font-size:20px;padding:10px;color:#333;font-weight:bold" >
        {{$detail->title}}
    </div>
    <div style="font-size: 14px;color:#999;padding:0 10px;text-align:right" >
        ￥<span style="font-size: 25px;color:#ff9531">{{$detail->price}}</span>元/人
        <div style="height:34px;width:90px;background:#518FE4;border-radius:2px;color:#fff;text-align: center;line-height:38px;font-size:17px;box-shadow: 1px 1px 15px rgba(255,255,255,0.2);padding:0px;display:inline-block;margin-left:10px;margin-bottom:10px;">点击报名</div>
    </div>

    <div style="font-size:16px;padding:10px;font-size:#333;line-height:25px;background:rgba(66,140,226,0.1);">
        <div>出发时间：{{$detail->startday}} </div>
            <div>返回时间：{{$detail->endday}}</div>
        <div> 领队&电话：{{$detail->leader}} {{$detail->phone}}</div>
        <div>集合时间：{{$detail->jihetime}}</div>
        <div>集合地点：{{$detail->jihedidian}}</div>
        <div>需要：{{$detail->need}}人 报名：{{$detail->baoming}}人 </div>

        <div>目的地：{{$detail->mudidi}}</div>
        <div>交通方式：{{$detail->jiaotong}}</div>
        <div>活动景点：{{$detail->jingdian}}</div>
        <div>活动内容：{{$detail->neirong}}</div>
        <div>距离：{{$detail->juli}} 强度：{{$detail->qiangdu}}</div>
    </div>
    <div class="tuwen" >{!! $detail->tuwen !!}</div>

    @include("wap.footer")

@stop

@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>
        $(document).ready(function () {
            var mySwiper = new Swiper ('.swiper-container', {
                autoplay:5000,
                loop: true,
                pagination: '.swiper-pagination'
            })
            $(".tuwen").find("*").css("width","auto");
            $(".tuwen").find("img").css("margin","5px 0");
            $(".tuwen").find("div").css({
                "padding":"0",
                "margin":"0",
            });
            $(".tuwen").css("display","block");
//            $(".tuwen img").css({
//                "height":"auto",
//            });
        });
    </script>

@stop