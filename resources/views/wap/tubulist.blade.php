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
        .newitem{
            height:105px;width:100%;position: relative;padding:10px;padding-left:150px;
            border-bottom:1px solid #ddd;
        }
        .img{
            width:130px;height:80px;top:10px;left:10px;background-image:url(/web/images/p1.jpg);
            position: absolute;background-size:cover;
        }
        .title{
            height:40px;overflow: hidden;line-height:20px;color:#333;
        }
        .price{
            color:orange;bottom:10px;right:10px;
            position: absolute;
        }
    </style>
@stop

@section("body")
    <div onclick="history.back()" style="width:40px;height:30px;background:rgba(0,0,0,0.3);color:#fff;position:fixed;left:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
        <span class="glyphicon glyphicon-menu-left" ></span>
    </div>
    <div class="content" >
        @for( $i=0;$i<count($list);$i++ )
            <a style="text-decoration: none" href="/tubu/tubudetail/{{$list[$i]->id}}">
            <div class="newitem" >
                <div class="img" style="background-image:url(/admin/data/images/{{$list[$i]->pictures}})"></div>
                <p class="title">{{$list[$i]->title}}</p>
                <span style="display:block;font-size:10px;color:#888;">出发时间：{{$list[$i]->startday}}</span>
                <span style="display:block;font-size:10px;color:#888">活动地点：{{$list[$i]->mudidi}}</span>
                <span class="price" >￥{{$list[$i]->price}}</span>
            </div>
            </a>
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