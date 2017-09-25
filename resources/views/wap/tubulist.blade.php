@extends("wap.common")
@section("title","徒步活动")
@section("css")

    <style>
        .tubuitem{
            width:99%;height:200px;background-size:cover;margin:0 auto;
            background-position:center;
            background-repeat:no-repeat;margin-top:7.5px;
            /*display: inline-block;*/
            position: relative;
        }
    </style>
@stop

@section("body")
    <div onclick="history.back()" style="width:40px;height:30px;background:rgba(0,0,0,0.3);color:#fff;position:fixed;left:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
        <span class="glyphicon glyphicon-menu-left" ></span>
    </div>
    <div class="content" >



        @for( $i=0;$i<count($list);$i++ )
            <a href="/tubu/tubudetail/{{$list[$i]->id}}"><div class="tubuitem" style="background-image:url(/admin/data/images/{{$list[$i]->pictures}})">
                <div style="position: absolute;bottom:20px;left:10px;color:#fff;">出发时间 {{$list[$i]->startday}}</div>
                <div style="height:38px;width:120px;background:#ff9531;border-radius:2px;color:#fff;text-align: center;line-height:38px;font-size:17px;position: absolute;right:15px;bottom:8px;box-shadow: 1px 1px 15px rgba(255,255,255,0.2);padding:0px;">点击报名</div>
            </div>
            <div style="padding:10px;">
                <p style="font-size:20px;color:#333;text-align:left;width:100%;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">{{$list[$i]->jingdian}}</p>
                <p style="font-size:14px;color:#999;">{{$list[$i]->title}}</p>

            </div></a>
        @endfor
        {!! $fenye !!}
    </div>

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
            $(".tuwen").find("div").css({
                "padding":"0",
                "margin":"0",
            });
//            $(".tuwen img").css({
//                "height":"auto",
//            });
        });
    </script>

@stop