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
                <a style="color: #999;" href="/tubulist/{{$detail->types}}" >{{$detail->name}}</a>
            </div>
            <div style="color:#4b8ee8;font-size:24px;">
                {{$detail->title}}
            </div>
            <div style="float: left;margin-top:30px;">
                <div class="swiper-container" id="swiper-container1">
                    <div style="height:40px;width:130px;background:rgba(75,142,232,0.8);position:absolute;left:0px;top:0px;z-index:9999;color:#fff;text-align: center;line-height:40px;font-size:18px;" >
                        @if( strtotime($detail->startday) - time() > 0 )
                            活动招募中
                            @else
                            活动已结束
                        @endif
                    </div>
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
                <div style="height:120px;background:#FFF8EE;width:100%;color:#444;padding:10px;" >
                    <p style="border-bottom:2px dashed orange;padding-bottom:10px;">活动价格：<span style="color:orange;font-size:30px;font-weight: bold;" >￥{{$detail->price}}</span><span style="color:#777;float:right;">活动报名截止：{{$detail->startday}}</span></p>
                    <p>
                        @if( !$isjoined )
                            活动特点：<span style="color:orange;">{{$detail->tese}}</span>
                        @endif


                        @if( strtotime($detail->startday) - time() > 0 )
                                @if( $isjoined )
                                    <span style="color:red;font-size:16px;">你已报名，请等待通知(出发前一天)，确保你的{{$phone}}保持畅通</span>
                                    @else
                                    <span style="float:right" ><button onclick="baoming({{$detail->id}})" type="button" class="btn btn-warning" style="width:150px;height:40px;font-size: 20px;outline:none">马上报名</button></span>
                                    @endif
                            @endif

                    </p>
                </div>

                <p style="margin-top:10px;">
                    领队：<span style="color:#4b8ee8">{{$detail->leader}}</span>
                    距离：<span style="color:#4b8ee8">{{$detail->juli}}</span>
                    <span style="color:orange;margin-left:10px;" >强度等级：</span><span style="color:#4b8ee8">{{$detail->qiangdu}}</span>
                </p>
                <p>
                    电话：<span style="color:#4b8ee8">{{$detail->phone}}</span>
                </p>
                {{--<p>--}}
                    {{--需要：<span style="color:#4b8ee8">{{$detail->need}}人</span>--}}
                    {{--报名：<span style="color:#4b8ee8">{{$detail->baoming}}人</span>--}}
                    {{--剩余：<span style="color:#4b8ee8">{{$detail->need - $detail->baoming}}人</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                    {{--目的地：<span style="color:#4b8ee8">{{$detail->mudidi}}</span>--}}
                {{--</p>--}}
                <p>
                    出发时间：<span style="color:#4b8ee8">{{$detail->startday}}</span>
                    返回时间：<span style="color:#4b8ee8">{{$detail->endday}}</span>
                </p>
                {{--<p>--}}
                    {{--活动景点：<span style="color:#4b8ee8">{{$detail->jingdian}}</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                    {{--活动内容：<span style="color:#4b8ee8">{{$detail->neirong}}</span>--}}
                {{--</p>--}}
                <p>
                    交通方式：<span style="color:#4b8ee8">{{$detail->jiaotong}}</span>
                </p>
                <p>
                    集合时间：<span style="color:#4b8ee8">{{$detail->jihetime}}</span>
                </p>
                @for( $data = explode("#",$detail->jihedidian),$i=0;$i<count($data);$i++  )
                    <p>
                        集合地点{{($i+1)}}：<span style="color:#4b8ee8">{{$data[$i]}}</span>
                    </p>
                @endfor



            </div>
            <div style="clear:both" ></div>
            <style>
                .tuwen{
                    text-align: center;width:800px;float:left;margin-top:30px;border:1px solid #efefef;padding:10px;
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
                .tubudetailnavbar{
                    border-bottom:1px solid #ddd;height:50px;width:100%;text-align: left;
                }
                .tubudetailnavbar a{
                    display:block;width:80px;height:30px;text-decoration: none;
                    line-height:30px;float:left;color:#333;margin-right:10px;
                    cursor: pointer;
                    text-align: center;background: #E6E6E6;margin-top:20px;
                }
                .tubudetailnavbar a:hover{
                    background: #4B8EE8;color:#fff;
                }

            </style>
            <div class="tuwen" >
                <div>{!! $detail->tuwen !!}</div>
                    <div id="lydp" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0;text-align: left;" >
                        <p>驴友点评</p>
                    </div>
                <div >
                    <textarea style="margin-top:10px;" class="form-control"  rows="5" placeholder="评论内容..."></textarea>
                    <button style="margin-top:10px;float:left  " class="btn btn-success " onclick="tubucm(this,{{$detail->id}})" >提交评论</button>
                </div>
                <div style="clear:both" ></div>
                <div class="liuyanbox">

                </div>
                <div onclick="gettubucms({{$detail->id}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
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
            gettubucms({{$detail->id}});
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
        function tubucm(t,tid) {
            var content = $(t).parent("div").children("textarea").val();
            if( $.trim(content) == ''  ) {
                toast("请输入评论内容"); return;
            }
            $.post("/tubucm",{"tid":tid,"content":content},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
        function gettubucms(yid) {
            if( window.liuyanpage ) {
                window.liuyanpage++;
            }else{
                window.liuyanpage = 1;
            }
            $.post("/gettubucms",{'yid':yid,"page":window.liuyanpage},function(d){
                if( res = ajaxdata(d) ) {
                    if( res.length == 0 && window.liuyanpage!=1 ) {
                        toast("没有更多了"); return ;
                    }
                    for( var i=0;i<res.length;i++ ) {
                        var item = `<div style="margin:20px 0;vertical-align: middle;">
                            <div onclick="location.href='/user/${res[i].uid}'" style="display: inline-block;height:60px;width:60px;background-image:url(/head/${res[i].uid});background-size:cover;background-position:center;border-radius:30px;vertical-align: middle;float:left;cursor:pointer;" ></div>
                            <div style="font-size:16px;padding:10px;float:left;max-width:600px;margin-left:20px;border-radius:5px;">${res[i].content}</div>
                            <div style="clear:both;margin-left:90px;color:#999;text-align: left;" >
                                ${res[i].ctime}
                            </div>
                        </div>`;
                        $(".liuyanbox").append(item);
                    }
                }
            })
        }
    </script>
@stop