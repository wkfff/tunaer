@extends("web.common")
@section("title","{$list->title} - 游记详情")

@section("css")
    <style>
        .tuijian{
            float:left;width:400px;height:100px;border:1px solid #eee;padding:10px;border-left:0px;
        }
        .youjiuserhead{
            width:30px;height:30px;background-size:cover;background-image:url(/head/{{$list->uid}});
            background-position: center;border-radius:15px;
            display: inline-block;
            vertical-align: middle;
            background-repeat:no-repeat;
        }
        .tuwen{
            text-align: center;width:760px;float:left;margin-top:30px;border:1px solid #eee;padding:10px;
            overflow: auto;
        }
        .tuwen img{
            max-width:100% !important;margin:2.5px 0;
        }
    </style>
@stop
@section("body")
    @include("web.header")
    <div class="content">

        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>
            @if( $list->type == 2 )<a style="color: #999;" href="/youjilist/2" >官方游记</a>
            @else<a style="color: #999;" href="/youjilist/1" >会员游记</a>
            @endif

        </div>
        <div class="left" style="width:800px;float:left;padding:20px;border:1px solid #eee;" >
            <div style="font-size:22px;text-align:center;">
                {{$list->title}}
            </div>

            <div style="font-size:14px;text-align:center;color:#999;margin:10px 0px;">
                @if( $list->type == 2 )<span>发布者:管s理员 </span>
                @else<span>发布者:{{$list->uname}} </span><a href="/user/{{$list->uid}}"><div class="youjiuserhead"  ></div></a>
                @endif

                <span style="margin-left:10px;">发布时间:{{$list->ytime}}</span>
                <span style="margin-left:10px;">阅读:{{$list->readcnt}}</span>
            </div>
            <div style="text-align:right;margin:30px 0;margin-right:50px;">
                <div class="bshare-custom"><div class="bsPromo bsPromo2"></div><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到堆糖" class="bshare-duitang" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count" style="float: none;">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                <div style="clear:both" ></div>
            </div>
            <div class="tuwen">
                {!! $list->tuwen !!}
            </div>
            <div >
                <button onclick="youjicm(this,{{$list->id}},2)"  type="button" class="btn btn-default btn-sm">
                    <img src="/web/images/xihuan.png" style="height:18px;"><span style="margin-left:10px;" >点赞 ({{$list->zancnt}})</span>
                </button>
                <textarea style="margin-top:10px;" class="form-control"  rows="5" placeholder="评论内容..."></textarea>
                <button style="margin-top:10px;" class="btn btn-success " onclick="youjicm(this,{{$list->id}},1)" style="margin-left:30px;">提交评论</button>
            </div>
            <div class="liuyanbox">

            </div>
            <div onclick="getyoujis({{$list->id}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
        </div>
        <div class="tuijian"   >
            <p style="color:#999;font-size:20px;">更多游记</p>
            @for( $i=0;$i<count($youjis);$i++ )
                <a href="/youji/detail/{{$youjis[$i]->id}}"><div style="width:400px;height:100px;margin-bottom:20px;color:#444;" >
                        <div style="height:100px;width:160px;float:left;background-size:cover;background-position: center;background-repeat:no-repeat;background-image:
                        @if($youjis[$i]->type == 2)
                                url(/admin/data/images/{{$youjis[$i]->pic}})
                        @else
                                url(/web/data/images/{{$youjis[$i]->pic}})
                        @endif
                        ;" ></div>
                        <div style="float:right;width:240px;height:100px;position:relative;">
                            <p style="line-height:30px;padding:0 10px;position:absolute;top:0px;" >{{$youjis[$i]->title}}</p>
                            <p style="line-height:25px;padding:0 10px;position:absolute;bottom:0px;background:#fff;" >{{$youjis[$i]->ytime}}</p>
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
//            console.log(scrollTop);
            if( scrollTop>=250 ) {
                $(".tuijian")[0].style = "position:fixed;top:10px;left:"+tuijianleft+"px"
            }else{
                $(".tuijian")[0].style="";
            }
        }
        $(document).ready(function () {
            window.tuijianleft = $(".tuijian")[0].getBoundingClientRect().left;
            getyoujis({{$list->id}});
        })

        function youjicm(t,yid,type) {
            var content = $(t).parent("div").children("textarea").val();
            if( type == 1) {
                if( $.trim(content) == ''  ) {
                    toast("请输入评论内容"); return;
                }
            }else{
                content = 'zan';
            }
            $.post("/youjicm",{"yid":yid,"content":content,"type":type},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
        function getyoujis(yid) {
            if( window.liuyanpage ) {
                window.liuyanpage++;
            }else{
                window.liuyanpage = 1;
            }
            $.post("/getyoujicms",{'yid':yid,"page":window.liuyanpage},function(d){
                if( res = ajaxdata(d) ) {
                    if( res.length == 0 && window.liuyanpage!=1 ) {
                        toast("没有更多了"); return ;
                    }
                    for( var i=0;i<res.length;i++ ) {
                        var item = "<div style=\"margin:20px 0;vertical-align: middle;\"> <div onclick=\"location.href='/user/"+res[i].uid+"'\" style=\"display: inline-block;height:60px;width:60px;background-image:url(/head/"+res[i].uid+");background-size:cover;background-position:center;border-radius:30px;vertical-align: middle;float:left;cursor:pointer;\" ></div> <div style=\"font-size:16px;padding:10px;float:left;max-width:600px;margin-left:20px;border-radius:5px;\">"+res[i].content+"<a href=\"javascript:void(0)\" onclick=\"huifu(this,"+res[i].id+",{{$list->id}})\">回复</a></div> <div style=\"clear:both;margin-left:90px;color:#999;\" > "+res[i].ltime+" </div> </div>";
                        $(".liuyanbox").append(item);
                        if( res[i].sub.length ) {
                            for( var j=0;j<res[i].sub.length;j++ ) {
                                var item = "<div style=\"margin:20px 0;vertical-align: middle;margin-left:60px;\"> <div onclick=\"location.href='/user/"+res[i].sub[j].uid+"'\" style=\"display: inline-block;height:60px;width:60px;background-image:url(/head/"+res[i].sub[j].uid+");background-size:cover;background-position:center;border-radius:30px;vertical-align: middle;float:left;cursor:pointer;\" ></div> <div style=\"font-size:16px;padding:10px;float:left;max-width:600px;margin-left:20px;border-radius:5px;\">"+res[i].sub[j].content+"</div> <div style=\"clear:both;margin-left:90px;color:#999;\" > "+res[i].sub[j].ltime+" </div> </div>";
                                $(".liuyanbox").append(item);
                            }
                        }
                    }
                }
            })
        }
        function huifu(that,pid,yid) {
            if( content = prompt("输入回复内容","") ) {
                $.post("/youjisubcomment",{"pid":pid,"content":content,"yid":yid},function(d){
                    if( ajaxdata(d) ) {
                        location.reload();
                    }
                })
            }
        }
    </script>
@stop
