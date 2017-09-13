@extends("web.common")
@section("title",$detail->title)
@section("css")

    <style>
        html{overflow-y:scroll;}
        body{margin:0; font:12px "\5B8B\4F53",san-serif;background:#ffffff;}
        div,ul,li{padding:0; margin:0;}
        li{list-style-type:none;}
        img{vertical-align:top;border:0;}

        /* box */
        /*.box{width:610px;margin:100px auto;}*/
        .tb-pic a{display:table-cell;text-align:center;vertical-align:middle;}
        .tb-pic a img{vertical-align:middle;}
        .tb-pic a{*display:block;*font-family:Arial;*line-height:1;}
        .tb-thumb{margin:10px 0 0;overflow:hidden;}
        .tb-thumb li{background:none repeat scroll 0 0 transparent;float:left;height:42px;margin:0 6px 0 0;overflow:hidden;padding:1px;}
        .tb-s400, .tb-s400 a{height:420px;width:420px;padding-left:5px;}
        .tb-s400, .tb-s400 img{max-height:420px;max-width:420px;}
        .tb-s400 a{*font-size:271px;}
        .tb-s40 a{*font-size:35px;}
        .tb-s40, .tb-s40 a{height:40px;width:40px;}
        .tb-booth{border:1px solid #eee;position:relative;z-index:1;}
        .tb-thumb .tb-selected{border:1px solid #C30008 ;height:40px;}
        .tb-thumb .tb-selected div{background-color:#FFFFFF;border:medium none;}
        .tb-thumb li div{border:1px solid #CDCDCD;}
        .zoomDiv{z-index:999;position:absolute;top:0px;left:0px;width:200px;height:200px;background:#ffffff;border:1px solid #CCCCCC;display:none;text-align:center;overflow:hidden;}
        .zoomMask{position:absolute;background:url("/web/images/mask.png") repeat scroll 0 0 transparent;cursor:move;z-index:1;}

        .colorlist span {
            height:30px;min-width:60px;display: inline-block;border:1px solid #eee;line-height:30px;text-align:center;
            margin-right:10px;margin-top:5px;cursor:pointer;
        }
        .colorlist span:hover{
            background-color: #f40;color:#fff;
        }
        .chicunlist span {
            height:30px;min-width:60px;display: inline-block;border:1px solid #eee;line-height:30px;text-align:center;
            margin-right:10px;margin-top:5px;cursor:pointer;
        }
        .chicunlist span:hover{
            background-color: #f40;color:#fff;
        }
        .searchb{
            width:180px;height:40px;border:none; border: 1px solid #FF0036;font-size:16px;
            letter-spacing: 4px; background:#ffeded;color: #FF0036;
            margin-right:20px;outline:none;
        }
        .searchb:active{
            opacity:0.7;color:#fff
        }
        .tuwen{
            width:100%;margin-top:30px;test-align:center;
        }
        /*.searchb:hover{*/
            /*opacity:0.7;color:#fff*/
        /*}*/

        .tuwen{
            text-align: center;width:860px;float:left;margin-top:30px;border:1px solid #eee;padding:10px;
            overflow: auto;
        }
        .tuwen img{
            max-width:100% !important;
        }
        .tuijian{
            width:310px;height:100px;float:right;
        }

    </style>
@stop

@section("body")
    @include("web.header")
    <div class="content">

        <div class="box" style="margin-top:20px;float:left;width:440px;">
            <div class="tb-booth tb-pic tb-s400">
                <a href="javascript:void(0)">
                    <div rel="#" class="jqzoom" style="background-image:url(#);background-size:cover;background-repeat:no-repeat;background-position: center;width:400px;height:400px;">
                    </div>
                </a>
            </div>
            <ul class="tb-thumb" id="thumblist">
                @for( $imgs = explode("#",$detail->pictures),$i=0;$i<count($imgs);$i++ )
                    <li >
                        <div class="tb-pic tb-s40" style="background-image:url(/admin/data/images/{{$imgs[$i]}});background-size:cover;background-repeat:no-repeat;background-position: center;" >
                    </li>
                @endfor

            </ul>
        </div>
        <div class="shopinfo" style="margin-top:20px;float:left;width:560px;padding-left:20px;position:relative;" >
            <div style="position: absolute;cursor:pointer;right:-150px;top:0px;width:150px;height:150px;border:1px solid #eee;">
                <div style="background-image:url(/web/images/gouwuche.png);background-size:cover;background-repeat:no-repeat;background-position: center;height:100px;width:100px;margin:0 auto;margin-top:5px;border-radius:50px;" ></div>
                <div style="text-align:center;font-size:20px;color:#f40;">购物车<span style="background:red;margin-left:5px;margin-top:-10px;" class="badge">42</span></div>
            </div>
            <div style="font-size:16px;color:#3C3C3C;font-weight:700;line-height:26px;max-width:500px;margin-top:10px;">
                {{$detail->title}}
            </div>
            <div style="height:60px;width:90%;background:#FFF2E8;font-size:14px;color:#666;line-height:60px;padding:0 20px;margin-top:20px;" >
                <span>价格　<span style="font-size:24px;color:#f40;font-weight:700;">¥ {{$detail->price}}</span></span>
                <span style="float:right">评价　<span style="color:#111">11</span></span>
                <span style="float:right;margin-right:20px;">已售　<span style="color:#111">{{$detail->sold}}</span></span>
            </div>
            <div style="width:90%;margin-top:20px;" >
                <span style="font-size:14px;margin-right:50px;">颜色分类</span>
                <div class="colorlist" style="margin-top:10px;display: inline;">
                    @for( $clist=explode("#",$detail->colorlist),$i=0;$i<count($clist);$i++ )
                        <span>{{$clist[$i]}}</span>
                    @endfor

                </div>
            </div>
            <div style="width:90%;margin-top:20px;" >
                <span style="font-size:14px;margin-right:50px;">可选尺寸</span>
                <div class="chicunlist" style="margin-top:10px;display: inline;">
                    @for( $chilist=explode("#",$detail->chicunlist),$i=0;$i<count($chilist);$i++ )
                        <span>{{$chilist[$i]}}</span>
                    @endfor
                </div>
            </div>
            <div style="width:90%;margin-top:20px;" >
                <span style="font-size:14px;margin-right:50px;">购买数量</span>

                <input type="number" value="1" style="width:70px;height:30px;text-align:center;" >
                <span style="margin-left:5px;">件</span>
                <span style="margin-left:30px;color:#666;">(库存{{$detail->kucun}}件)</span>
            </div>
            <div style="width:90%;margin-top:20px;">
                <button onclick="search()" class="searchb"  >立即购买</button>
                <button onclick="search()" class="searchb" style="background:#FF0036;color:#fff"  ><span class="glyphicon glyphicon-lock" ></span>加入购物车</button>
            </div>
            <div style="margin-top:20px;">
                <span style="margin-bottom:10px;">分享</span>
                <div class="bshare-custom"><div class="bsPromo bsPromo2"></div><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到堆糖" class="bshare-duitang" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count" style="float: none;">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
            </div>
        </div>

        <div style="clear:both" ></div>
        <div class="tuwen">
            {!! $detail->tuwen !!}
        </div>
        <div class="tuijian" >
            <p style="font-size:16px; " >推荐商品</p>
            @for($i=0;$i<count($tuijian);$i++)
                <a href="/shop/detail/{{$tuijian[$i]->id}}"><div style="background-image:url(/admin/data/images/{{$tuijian[$i]->pictures}});height:200px;width:300px;background-size:cover;background-position:center;position:relative;margin-bottom:70px;" >
                <div style="height:30px;line-height:30px;width:100%;overflow: hidden;font-size:14px;text-align:center;position:absolute;bottom:-30px;" >{{$tuijian[$i]->title}}</div>
                <div style="height:30px;line-height:30px;width:100%;overflow: hidden;font-size:16px;text-align:center;position:absolute;bottom:-60px;color:#f40" >¥ {{$tuijian[$i]->price}}</div>
            </div></a>
            @endfor

        </div>
        <div style="clear:both" ></div>
    </div>
    @include("web.footer")

@stop

@section("htmlend")
    <script type="text/javascript" src="/web/js/jquery.imagezoom.js"></script>
    <script>
        $(document).ready(function(){
            $(".jqzoom").imagezoom();
            $("#thumblist li div").click(function(){
                //增加点击的li的class:tb-selected，去掉其他的tb-selecte
                $(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
                //赋值属性
                var url = $(this).css("background-image");
                var pic = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];
//                $(".jqzoom").attr('src',$(this).find("img").attr("mid"));
                $(".jqzoom").attr('rel',"/admin/data/images/"+pic);

                $(".jqzoom").css("background-image",url);
            });
            $($("#thumblist li div")[0]).trigger("click");
        });
    </script>
@stop