@extends("web.common")
@section("title",$detail->title)
@section("css")
    <link rel="stylesheet" href="/web/css/index.css">
    <link rel="stylesheet" href="/web/css/swiper-3.4.2.min.css">
    <style>
        .swiper-container {
            width: 600px;
            height: 400px;
            float: left;margin-top:30px;
        }
        .swiper-slide{
            background-size:cover;background-repeat:no-repeat;background-position:center;
        }
        .swiper-pagination-bullet-active{
            background: #194C8E !important;
        }
    </style>
@stop

@section("body")
    @include("web.header")
        <div class="content">
            <div style="font-size: 18px;color: #999;margin:30px 0">
                <a style="color: #999;" href="/">首页</a>
                <span>></span>
                <a style="color: #999;" href="javascript:void(0)" onclick="location.reload();">徒步活动</a>
            </div>
            <div style="color:#4b8ee8;font-size:24px;">
                黄石国家公园班夫国家公园- 穿越美加落基山脉CVA2017世界经典徒步线路
            </div>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" style="background-image:url(/web/images/banner0.jpg);"></div>
                    <div class="swiper-slide" style="background-image:url(/web/images/banner1.jpg);"></div>
                    <div class="swiper-slide" style="background-image:url(/web/images/banner2.jpg);"></div>
                    <div class="swiper-slide" style="background-image:url(/web/images/banner3.jpg);"></div>
                    <div class="swiper-slide" style="background-image:url(/web/images/banner4.jpg);"></div>
                </div>
                <!-- 如果需要分页器 -->
                <div class="swiper-pagination"></div>
            </div>
            <div style="width:560px;margin-left:40px;float:left;margin-top:30px;font-size:16px;line-height: 30px" >
                <p>活动主题：<span style="color:#d85803">穿越美加落基山脉（黄石、班夫）国家公园</span></p>
                <p>价格：<span style="color:#d85803" >￥28800.00</span></p>
                <p>
                    领队：<span style="color:#4b8ee8">张子桥</span>
                    距离：<span style="color:#4b8ee8">180km</span>
                </p>
                <p>
                    电话：<span style="color:#4b8ee8">张子桥</span>
                </p>
                <p>
                    需要：<span style="color:#4b8ee8">25人</span>
                    报名：<span style="color:#4b8ee8">9人</span>
                    剩余：<span style="color:#4b8ee8">16人</span>
                </p>
                <p>
                    目的地：<span style="color:#4b8ee8">国外</span>
                </p>
                <p>
                    出发时间：<span style="color:#4b8ee8">2017年09月25日</span>
                    返回时间：<span style="color:#4b8ee8">2017年10月11日</span>
                </p>
                <p>
                    活动景点：<span style="color:#4b8ee8">加拿大班夫国家公园，美国优胜美地国家公园，黄石公园，拱门公园，峡谷地公园及锡安国家公园</span>
                </p>
                <p>
                    活动内容：<span style="color:#4b8ee8">休闲,徒步,摄影,其他</span>
                </p>
                <p>
                    集合时间：<span style="color:#4b8ee8">2017年09月25日</span>
                </p>
                <p>
                    集合地点：<span style="color:#4b8ee8">北京国际机场</span>
                </p>
                <p>
                    <span style="color:orange" >强度等级：</span><span style="color:#4b8ee8">休闲</span>
                </p>
                <p>
                    交通方式：<span style="color:#4b8ee8">包车</span>
                </p>


            </div>
            <div style="clear:both" ></div>
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