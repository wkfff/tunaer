@extends("wap.common")
@section("title","徒步资讯")
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

    <div  style="width:100%;height:45px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:45px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:45px;" class="glyphicon glyphicon-menu-left" ></span>
        <span>徒步资讯</span>
    </div>
    <div class="content" style="margin-top:50px;" >

        @for( $i=0;$i<count($list);$i++ )
            <a href="/zixun/detail/{{$list[$i]->id}}"><div class="tubuitem" style="background-image:url(/admin/data/images/{{$list[$i]->pic}})">
                    <div style="position: absolute;bottom:20px;left:10px;color:#fff;">阅读： {{$list[$i]->readcnt}}</div>
                    {{--<div style="height:38px;width:120px;background:#ff9531;border-radius:2px;color:#fff;text-align: center;line-height:38px;font-size:17px;position: absolute;right:15px;bottom:8px;box-shadow: 1px 1px 15px rgba(255,255,255,0.2);padding:0px;">点击报名</div>--}}
                </div>
                <div style="padding:10px;">
{{--                    <p style="font-size:20px;color:#333;text-align:left;width:100%;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">{{$list[$i]->readcnt}}</p>--}}
                    <p style="font-size:16px;color:#333;">{{$list[$i]->title}}</p>

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