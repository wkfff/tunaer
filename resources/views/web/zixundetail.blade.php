@extends("web.common")
@section("title","徒步资讯")

@section("css")
    <style>
        .tuijian{
            float:left;width:400px;height:100px;border:1px solid #eee;padding:10px;border-left:0px;
        }
        .tuwen{
            text-align: center;width:760px;float:left;margin-top:30px;border:1px solid #eee;padding:10px;
        }
        .tuwen img{
            max-width:100% !important;
        }


    </style>
    @stop
@section("body")
    @include("web.header")
    <div class="content">

        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>
            <a style="color: #999;" href="/zixun" >行业资讯</a>
        </div>
        <div class="left" style="width:800px;float:left;padding:20px;border:1px solid #eee;" >
            <div style="font-size:22px;text-align:center;">
                {{$list->title}}
            </div>

            <div style="font-size:14px;text-align:center;color:#999;margin:10px 0px;">
                <span>发布者:管理员 </span><span style="margin-left:10px;">发布时间:{{$list->ptime}}</span>
                <span style="margin-left:10px;">阅读:{{$list->readcnt}}</span>
            </div>
            <div style="text-align:right;margin:30px 0;margin-right:50px;">
                <div class="bshare-custom"><div class="bsPromo bsPromo2"></div><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到堆糖" class="bshare-duitang" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count" style="float: none;">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                <div style="clear:both" ></div>
            </div>
            <div class="tuwen">
                {!! $list->tuwen !!}
            </div>
        </div>
        <div class="tuijian"   >
            <p style="color:#999;font-size:20px;">推荐活动</p>
            @for( $i=0;$i<count($zixuns);$i++ )
                <a href="/zixun/detail/{{$zixuns[$i]->id}}"><div style="width:400px;height:100px;margin-bottom:20px;color:#444;" >
                    <div style="height:100px;width:160px;float:left;background-size:cover;background-position: center;background-repeat:no-repeat;background-image:url(/admin/data/images/{{$zixuns[$i]->pic}});" ></div>
                    <div style="float:right;width:240px;height:100px;position:relative;">
                        <p style="line-height:30px;padding:0 10px;position:absolute;top:0px;" >{{$zixuns[$i]->title}}</p>
                        <p style="line-height:25px;padding:0 10px;position:absolute;bottom:0px;background:#fff;" >{{$zixuns[$i]->ptime}}</p>
                    </div>
                </div></a>
            @endfor
        </div>
        <div style="clear:both" ></div>

    </div>
    @include("web.footer")

@stop

@section("htmlend")
    <script>
        window.onscroll = function(){
            if( !window.tuijianleft ) {
                return ;
            }
            var t = $(".tuijian")[0].getBoundingClientRect();

            var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
            console.log(scrollTop);
            if( scrollTop>=250 ) {
                $(".tuijian")[0].style = "position:fixed;top:10px;left:"+tuijianleft+"px"
            }else{
                $(".tuijian")[0].style="";
            }
        }
        $(document).ready(function () {
            window.tuijianleft = $(".tuijian")[0].getBoundingClientRect().left;
        })
    </script>
@stop
