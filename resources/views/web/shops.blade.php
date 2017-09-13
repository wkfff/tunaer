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
        .subsort{
            width:600px;height:380px;color:#444;top:20px;position: absolute;z-index: 2;
            padding-top:20px;left:200px;display: none;background:rgba(255,255,255,0.99);
        }
        .sort{
            width:200px;height:400px;background:rgba(0,0,0,0.5);top:-400px;position: absolute;z-index: 2;padding-top:20px;
        }
        .sort li{
            color:#f6f6f6;text-decoration: none;list-style: none;width:100%;height:40px;
            line-height:40px;display:block;font-size:14px;
            cursor: pointer;text-align: left;padding:0 15px;
        }
        .sort li:hover{
            background:#fff;color:#444;
        }
        .subsort i{
            margin:10px;color:#666;text-decoration: none;border-left:1px solid #999;padding-left:10px;
            display: inline-block;min-width:50px;height:10px;line-height:10px;
            font-style:normal;
            text-align: center;
        }
        .subsort i:hover{
            color:deeppink;
        }
        .shopitem{
            height:370px;width:260px;float:left;margin:20px;
        }
        .shopitem:hover{
            opacity: 0.8;
        }
        .shoppic{
            height:260px;width:258px;background-position:center;background-size:cover;
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
        <div class="sort" >

            <p style="height:40px;background:deeppink;color:#fff;text-align: center;line-height:40px;font-size: 16px;margin:0px;">
                <span>徒哪儿户外装备</span>
            </p>
            <p style="height:40px;background:none;color:#fff;text-align: left;line-height:40px;font-size: 16px;margin:0px;position:relative;">
                <input class="searchkey" onkeydown="searchkey(2)" placeholder="搜索商品" type="text" style="height:40px;width:200px;border:none;background:none;background:rgba(255,255,255,0.8);text-align: center;font-size:14px;color:#666;letter-spacing: 2px;">
                <span class="glyphicon glyphicon-search" onclick="searchkey(3)" style="position:absolute;right:15px;top:10px;color:#999;font-size:20px;cursor:pointer;"></span>
            </p>

        </div>

        <div class="shoplist" style="padding-top:20px;min-height:500px;" >
            @if( count($list) == 0 )
                <p>没有找到商品~</p>
            @endif
            @for( $i=0;$i<count($list);$i++ )
                <a href="/shop/detail/{{$list[$i]->id}}"><div class="shopitem" >
                <div class="shoppic" style="background-image:url(/admin/data/images/{{$list[$i]->pictures}});" ></div>
                <div style="padding:10px;">
                    <span style="color:#F40;font-size:18px;">¥{{$list[$i]->price}}</span>
                    <span style="float:right;color:#888;">已售{{$list[$i]->sold}}件</span>
                </div>
                <div style="padding:10px;">
                    <span>{{$list[$i]->title}}</span>
                </div>
            </div></a>
            @endfor
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

            loadfenlei();
        });

        function mover(that){
            $(that).children("div").toggle();
        }
        function mout(that){
            $(that).children("div").toggle();
        }
        function loadfenlei() {
            var data = eval({!! $fenlei !!});
            for( var i=0;i<data.length;i++ ) {
                if( $(".sort"+data[i].id).length == 0 ) {
//                    console.log(data[i].title);
                    $(".sort").append("<li onmouseover='mover(this)' onmouseout='mover(this)' class='sort"+data[i].id+"'><span onclick='searchsort(this)' search='"+data[i].id+"' >"+data[i].title+"</span><span style='float:right;line-height:40px;color:rgba(255,255,255,0.9)' class='glyphicon glyphicon-menu-right'></span><div class='subsort subsort"+data[i].id+"' ></div></li>");
                    for( var j=0;j<data.length;j++ ) {
                        if( data[j].pid == data[i].id) {
                            $(".subsort"+data[j].pid).append("<i search='"+data[j].pid+"_"+data[j].subid+"' onclick='searchsort(this)' href='javascript:void(0)'>"+data[j].subtitle+"</i>");
                        }
                    }
                }
            }
        }
        function searchkey(type) {

            if( type == 3 ) {
                var key = $(".searchkey").val();
                if( $.trim(key) != '' ) {
                    location.href="/shops/key/"+key;
                }

            }else{
                if( event.keyCode == 13 ) {
                    var key = $(".searchkey").val();
                    if( $.trim(key) != '' ) {
                        location.href="/shops/key/"+key;
                    }
                }
            }
            zuzhi(event);
        }
        function searchsort(that) {
            location.href="/shops/sort/"+$(that).attr("search");
        }

    </script>
@stop
