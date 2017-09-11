@extends("web.common")
@section("title","徒步商城")
@section("css")
    <link rel="stylesheet" href="/web/css/swiper-3.4.2.min.css">
    <style>
        .swiper-container {
            width: 100%;
            height: 400px;
        }
        .swiper-slide{
            background-size:cover;background-repeat:no-repeat;background-position:center;
        }
        .swiper-pagination-bullet{
            border-radius:0 !important;
            width:30px !important;height:3px !important;backrgound:red !important;
        }
        .swiper-pagination-bullet-active{
            background: deeppink !important;
            border-raidus:0 !important;
        }
        .smallsort{
            width:600px;height:380px;background:rgba(182,182,180,0.95);color:#444;top:-390px;position: absolute;z-index: 2;padding-top:20px;left:200px;
        }
        .bigsort{
            width:200px;height:400px;background:rgba(0,0,0,0.9);top:-410px;position: absolute;z-index: 2;padding-top:20px;
        }
        .bigsort li{
            color:#f6f6f6;text-decoration: none;list-style: none;width:100%;height:40px;
            line-height:40px;display:block;font-size:14px;
            position: relative;
            cursor: pointer;text-align: left;padding:0 15px;
        }
        .bigsort li:hover{
            background:rgba(255,255,255,0.7);color:#444;
        }
    </style>
@stop

@section("body")
    @include("web.header")
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            if( empty(Session::get("shopbanners")) ) {
                $sql = " select * from shopbanner order by sort desc ";
                $banners = DB::select($sql);
                Session::put("shopbanners",$banners);
            }
            $banners = Session::get("shopbanners");

            ?>
            @for( $i=0;$i<count($banners);$i++ )
                <div onclick="location.href='{{$banners[$i]->url}}'" class="swiper-slide" title="{{$banners[$i]->title}}" style="background-image:url(/admin/data/images/{{$banners[$i]->pic}});"></div>
            @endfor
        </div>
        <!-- 如果需要分页器 -->
        <div class="swiper-pagination"></div>
    </div>


    </div>
    <div class="content">
        <div class="bigsort" >
            <p style="height:40px;background:deeppink;color:#fff;text-align: center;line-height:40px;font-size: 16px;margin:0px;">
                <span>徒步/旅游 装备</span>

            </p>
            <li>登山，女鞋，男鞋<span style="float:right;line-height:40px;" class="glyphicon glyphicon-menu-right"></span></li>
            <li>旅游背包，帐篷<span style="float:right;line-height:40px;" class="glyphicon glyphicon-menu-right"></span></li>
            <li>旅游手辣带，登山仗<span style="float:right;line-height:40px;" class="glyphicon glyphicon-menu-right"></span></li>
            <li>防水衣，水壶<span style="float:right;line-height:40px;" class="glyphicon glyphicon-menu-right"></span></li>
            <li>探险装备，运动包<span style="float:right;line-height:40px;" class="glyphicon glyphicon-menu-right"></span></li>
            <li>吸汗，包裹性，速干<span style="float:right;line-height:40px;" class="glyphicon glyphicon-menu-right"></span></li>
            <li>徒步鞋，雨衣成人<span style="float:right;line-height:40px;" class="glyphicon glyphicon-menu-right"></span></li>
        </div>
        <div class="smallsort" >

        </div>
        <div style="clear:both" ></div>
        {!! $fenye !!}

    </div>
    @include("web.footer")

@stop
@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>
        $(document).ready(function () {
            var mySwiper = new Swiper ('.swiper-container', {
                // direction: 'vertical',
                loop: true,

                // 如果需要分页器
                pagination: '.swiper-pagination'
            })
        });
    </script>
@stop
