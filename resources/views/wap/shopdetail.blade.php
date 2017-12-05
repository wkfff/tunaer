@extends("wap.common")
@section("title","活动详情")
@section("css")
    <link rel="stylesheet" href="/web/css/swiper-3.4.2.min.css">
    <style>
        .swiper-container {
            width: 99%;
            height: 350px;
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
        .searchb{
            width:120px;height:50px;border:none;font-size: 1em;
            letter-spacing: 3px; background:#ffeded;color: #FF0036;  outline:none;
        }
        .colorlist span {
            height:30px;min-width:60px;display: inline-block;border:1px solid #eee;line-height:30px;text-align:center;
            margin-right:10px;margin-top:5px;cursor:pointer;padding:0 5px;
        }

        .chicunlist span {
            height:30px;min-width:60px;display: inline-block;border:1px solid #eee;line-height:30px;text-align:center;
            margin-right:10px;margin-top:5px;cursor:pointer;padding:0 5px;
        }

        .colorhover {
            background-color: #f40;color:#fff;
        }
        .chicunhover {
            background-color: #f40;color:#fff;
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
        <div class="shopinfo" style="margin-top:20px;float:left;width:100%;padding:10px;position:relative;" >

            <div style="font-size:16px;color:#3C3C3C;font-weight:700;line-height:26px;max-width:500px;margin-top:0px;">
                {{$detail->title}}
            </div>
            <div style="height:60px;background:#FFF2E8;font-size:14px;color:#666;line-height:60px;padding:0 10px;margin-top:10px;" >
                <span>价格　<span style="font-size:24px;color:#f40;font-weight:700;">¥ {{$detail->price}}</span></span>
                <span style="float:right">评价　<span style="color:#111">11</span></span>
                <span style="float:right;margin-right:20px;">已售　<span style="color:#111">{{$detail->sold}}</span></span>
            </div>
            <div style="width:90%;margin-top:20px;" >
                <span style="font-size:14px;margin-right:50px;">颜色分类</span><br>
                <div class="colorlist" style="margin-top:10px;display: inline;">
                    @for( $clist=explode("#",$detail->colorlist),$i=0;$i<count($clist);$i++ )
                        <span onclick="choicecolor(this)">{{$clist[$i]}}</span>
                    @endfor

                </div>
            </div>
            <div style="width:90%;margin-top:20px;" >
                <span style="font-size:14px;margin-right:50px;">可选尺寸</span><br>
                <div class="chicunlist" style="margin-top:10px;display: inline;">
                    @for( $chilist=explode("#",$detail->chicunlist),$i=0;$i<count($chilist);$i++ )
                        <span onclick="choicechicun(this)">{{$chilist[$i]}}</span>
                    @endfor
                </div>
            </div>
            <div style="width:90%;margin-top:20px;" >
                <span style="font-size:14px;margin-right:20px;">购买数量</span>

                <input id="item_num" type="number" value="1" style="width:70px;height:30px;text-align:center;" >
                <span style="margin-left:5px;">件</span>
                <span style="margin-left:10px;color:#666;">(库存{{$detail->kucun}}件)</span>
            </div>


        </div>

        <div style="clear:both" ></div>
        <div class="tuwen">
            {!! $detail->tuwen !!}
        </div>

        <div style="width:100%;position:fixed;bottom:0px;left:0px;background:#eee;width:100%;z-index:999;height:50px;">
            <button onclick="goumai()"  class="searchb" style="float:right;width:30%;background:#FF0036;color:#fff"  >立即购买</button>
            <button onclick="addgouwuche()" class="searchb" style="float:right;width:30%;background:#FFB03F;color:#fff"  >加入购物车</button>
            <a href="/gouwuche"><div style="float:right;width:20%;color:#666;text-align:center;position:relative;"  >
                <img src="/web/images/icon-cart.png" style="height:25px;margin-top:5px;">
                <p style="font-size:13px;">购物车</p>
                <span style="background:red;position: absolute;top:0px;right:0px;" class="badge" id="gouwuchenum"></span>
            </div></a>
            <div style="float:right;width:20%;color:#666;text-align:center;"  >
                <img src="/web/images/icon-kefu.png" style="height:25px;margin-top:5px;">
                <a href="tel:18000548612"><p style="font-size:13px;color:#666;">客服</p></a>
            </div>
        </div>
        <div style="clear:both" ></div>
        <div style="height:10px;" ></div>
    </div>
    {{--@include("wap.footer")--}}
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
            if( localStorage.getItem("gouwuche") ) {
                gouwuche = JSON.parse( localStorage.getItem("gouwuche") );
                $("#gouwuchenum").text(gouwuche.length);
            }
        });
        function addgouwuche() {
            var item_num = $("#item_num").val();
            if (item_num < 1) {
                toast("购买数量有误");
                return;
            }
            var item_color = $(".colorhover").text();
            if ($.trim(item_color) == '') {
                toast("请选择颜色分类");
                return;
            }
            var item_chicun = $(".chicunhover").text();
            if ($.trim(item_chicun) == '') {
                toast("请选择尺寸");
                return;
            }
            var pic = "{{$detail->pictures}}";
            var title = "{{$detail->title}}";
            var price = "{{$detail->price}}";
            var id = "{{$detail->id}}";
            var num = item_num;
            var color = item_color;
            var chicun = item_chicun;
            var gouwuche = new Array();
            if (localStorage.getItem("gouwuche")) {
                gouwuche = JSON.parse(localStorage.getItem("gouwuche"));
            }
            for (var i = 0; i < gouwuche.length; i++) {
                var shopId = gouwuche[i].split("__")[0];
                if (shopId == id) {
                    gouwuche.splice(i, 1);
                }

            }
            var tmp = id + "__" + pic.split("#")[0] + "__" + title + "__" + price + "__" + num + "__" + color + "__" + chicun;
            gouwuche.push(tmp);
            $("#gouwuchenum").text(gouwuche.length);
            localStorage.setItem("gouwuche", JSON.stringify(gouwuche));
        }

        function choicechicun(that) {
            window.item_chicun = $(that).val();
            $(".chicunhover").removeClass("chicunhover");
            $(that).addClass("chicunhover");
        }
        //        选择颜色
        function choicecolor(that) {
            window.item_color = $(that).val();
            $(".colorhover").removeClass("colorhover");
            $(that).addClass("colorhover");
        }

        function goumai() {
            var item_num = $("#item_num").val();
            if( item_num < 1 ) {
                toast("购买数量有误"); return;
            }
            var item_color = $(".colorhover").text();
            if( $.trim(item_color) == '' ) {
                toast("请选择颜色分类"); return;
            }
            var item_chicun = $(".chicunhover").text();
            if( $.trim(item_chicun) == '' ) {
                toast("请选择尺寸"); return;
            }
            var item_id = "{{$detail->id}}";
            location.href="/goumai?id="+item_id+"&chicun="+item_chicun+"&color="+item_color+"&num="+item_num;
        }

    </script>

@stop