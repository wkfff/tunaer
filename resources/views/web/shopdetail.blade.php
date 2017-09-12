@extends("web.common")
@section("title",$detail->title)
@section("css")
    <link rel="stylesheet" href="/web/css/index.css">
    <link rel="stylesheet" href="/web/css/swiper-3.4.2.min.css">
    <style>
        .swiper-container {
            width: 600px;
            height: 400px;

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
            <a style="color: #999;" href="/shops" >商城首页</a>
        </div>
        <div style="color:#4b8ee8;font-size:24px;">
            {{$detail->title}}
        </div>
        <div style="float: left;margin-top:30px;">
            <div class="swiper-container" id="swiper-container1">
                <div class="swiper-wrapper">
                    @for( $imgs = explode("#",$detail->pictures),$i=0;$i<count($imgs);$i++ )
                        <div class="swiper-slide" style="background-image:url(/admin/data/images/{{$imgs[$i]}});"></div>
                    @endfor
                </div>
            </div>
            <div class="swiper-container" id="swiper-container2" style="margin-top:20px;height:140px;">
                <div class="swiper-wrapper">
                    @for( $imgs = explode("#",$detail->pictures),$i=0;$i<count($imgs);$i++ )
                        <div class="swiper-slide" style="background-image:url(/admin/data/images/{{$imgs[$i]}});width:100px;height:120px;"></div>
                    @endfor
                </div>
            </div>
            <div style="float:left" class="bshare-custom icon-medium-plus"><div class="bsPromo bsPromo2"></div><a title="分享到" href="http://www.bShare.cn/" id="bshare-shareto" class="bshare-more">分享到</a><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到豆瓣" class="bshare-douban" href="javascript:void(0);"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到天涯" class="bshare-tianya" href="javascript:void(0);"></a><a title="分享到堆糖" class="bshare-duitang" href="javascript:void(0);"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="分享到一键通" class="bshare-bsharesync" href="javascript:void(0);"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count" style="float: none;">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
        </div>

        <div style="width:560px;margin-left:40px;float:left;margin-top:30px;font-size:16px;line-height: 30px" >

            <button onclick="baoming({{$detail->id}})" type="button" class="btn btn-primary"
                    style="width:200px;height:50px;font-size: 20px;outline:none">马上报名</button>
        </div>
        <div style="clear:both" ></div>
        <style>
            .tuwen{
                text-align: center;width:800px;float:left;margin-top:30px;border:1px solid #eee;padding:10px;
            }
            .tuwen img{
                max-width:100% !important;
            }
            .tuijian{
                float:left;width:330px;margin-top:30px;margin-left:20px;border:1px solid #eee;padding:10px;
                z-index:999;
            }
            .tuijian div{
                height:180px;width:310px;background:#eee;background-size:cover;
                background-position:center;background-repeat: no-repeat;
                position: relative;margin-top:20px;
            }
            .tuijian div:hover{
                opacity:0.8;
            }

        </style>
        <div class="tuwen" >
            {!! $detail->tuwen !!}
        </div>
        <div class="tuijian" >
            <p style="color:#999;font-size:20px;">推荐活动</p>

        </div>
        <div style="clear:both" ></div>
    </div>
    @include("web.footer")

@stop

@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>

    </script>
@stop