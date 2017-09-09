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
                <a style="color: #999;" href="/tubulist/{{$detail->types}}" ">{{$detail->name}}</a>
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
                <p>活动主题：<span style="color:#d85803">{{$detail->title}}</span></p>
                <p>价格：<span style="color:#d85803" >￥{{$detail->price}}</span></p>
                <p>
                    领队：<span style="color:#4b8ee8">{{$detail->leader}}</span>
                    距离：<span style="color:#4b8ee8">{{$detail->juli}}</span>
                    <span style="color:orange;margin-left:10px;" >强度等级：</span><span style="color:#4b8ee8">{{$detail->qiangdu}}</span>
                </p>
                <p>
                    电话：<span style="color:#4b8ee8">{{$detail->phone}}</span>
                </p>
                <p>
                    需要：<span style="color:#4b8ee8">{{$detail->need}}人</span>
                    报名：<span style="color:#4b8ee8">{{$detail->baoming}}人</span>
                    剩余：<span style="color:#4b8ee8">{{$detail->need - $detail->baoming}}人</span>
                </p>
                <p>
                    目的地：<span style="color:#4b8ee8">{{$detail->mudidi}}</span>
                </p>
                <p>
                    出发时间：<span style="color:#4b8ee8">{{$detail->startday}}</span>
                    返回时间：<span style="color:#4b8ee8">{{$detail->endday}}</span>
                </p>
                <p>
                    活动景点：<span style="color:#4b8ee8">{{$detail->jingdian}}</span>
                </p>
                <p>
                    活动内容：<span style="color:#4b8ee8">{{$detail->neirong}}</span>
                </p>
                <p>
                    集合时间：<span style="color:#4b8ee8">{{$detail->jihetime}}</span>
                </p>
                <p>
                    集合地点：<span style="color:#4b8ee8">{{$detail->jihedidian}}</span>
                </p>
                <p>
                    交通方式：<span style="color:#4b8ee8">{{$detail->jiaotong}}</span>
                </p>
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

        window.onscroll = function(){
            if( !window.tuijianleft ) {
                return ;
            }
            var t = $(".tuijian")[0].getBoundingClientRect();

            var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
//            console.log(scrollTop);
            if( scrollTop>=1100 ) {
                $(".tuijian")[0].style = "position:fixed;top:-30px;left:"+tuijianleft+"px"
            }else{
                $(".tuijian")[0].style="";
            }
        }
        $(document).ready(function () {
            window.tuijianleft = $(".tuijian")[0].getBoundingClientRect().left;
            var Swiper1 = new Swiper ('#swiper-container1', {
                initialSlide :1,
            })
            var Swiper2 = new Swiper ('#swiper-container2', {
                slidesPerView: 3,
                spaceBetween: 30,
                initialSlide :1,
                centeredSlides: true,
                slidesOffsetBefore:0,
                slideToClickedSlide:true
            })
            Swiper1.params.control = Swiper2;//需要在Swiper2初始化后，Swiper1控制Swiper2
            Swiper2.params.control = Swiper1;
            gettuijian();
        });

        function gettuijian() {
            $.post("/tubu/huodongtuijian",{"num":3},function(d){
                if( d = ajaxdata(d) ) {
                    $(".tuijian").children("a").remove();
                    for( var i=0; i<d.length;i++ ) {
                        var item = `<a href="/tubu/tubudetail/${d[i].id}"><div style="background-image:url(/admin/data/images/${d[i].pictures});" >
                                        <span style="display:block;position: absolute;bottom:0px;color:#fff;background:rgba(0,0,0,0.5);padding:10px;" >${d[i].title}
                                        </span>
                                        </div>
                                    </a>`;
                        $(".tuijian").append(item);

                    }
                }
            })
        }

        function baoming(id) {
            $.post("/tubu/baoming",{"tid":id},function(d){
                if( ajaxdata(d) ) {
                    toast("报名成功");
                }
            })
        }
    </script>
@stop