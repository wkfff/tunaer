@extends("wap.common")
@section("title",$detail->title)
@section("css")
    <link rel="stylesheet" href="/web/css/swiper-3.4.2.min.css">
    <style>
        .swiper-container {
            width: 99%;
            height: 200px;
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
        .tubudetailnavbar{
            width:100%;text-align: left;
            position: relative;border-bottom:1px solid orangered;
            line-height:40px;background: white;z-index:10;
        }
        .tubudetailnavbar a{
            display:block;height:40px;text-decoration: none;  float:left;color:#333;
            cursor: pointer;width:25%;
            text-align: center;
        }
        .tubudetailnavbar a:hover{
            background: #4B8EE8;color:#fff;
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
            <div style="height:40px;position:absolute;bottom:0px;left:0px;z-index:1;background:rgba(0,0,0,0.2);padding:10px;color:#fff;width:100%;" >
                <div onclick="tubucm(this,{{$detail->id}},2)" style="height:20px;float:left;margin-left:20px;cursor:pointer;" >
                    <span class="glyphicon glyphicon-comment"></span>
                    <span>{{$detail->cmcnt}}</span>
                </div>
                <div onclick="tubucm(this,{{$detail->id}},2)" style="height:20px;float:left;margin-left:20px;cursor:pointer;" >
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    <span>{{$detail->zancnt}}</span>
                </div>
            </div>
        </div>
    </div>
    <div style="font-size:18px;padding:10px;color:#444;font-weight:bold" >
        {{$detail->title}}
    </div>
    <div style="height:120px;background:#FFF8EE;width:100%;color:#444;padding:10px;" >
        <p style="border-bottom:2px dashed orange;padding-bottom:10px;line-height:35px;color:#999;font-size:16px;">活动价格：<span style="color:orange;font-size:30px;font-weight: bold;" >￥{{$detail->price}}</span><span style="color:#777;float:right;">{{$detail->startday}} 截止报名</span></p>
        <p style="line-height:35px;color:#999;font-size:16px;">
            活动特点：
            @for( $tesearr = explode("#",$detail->tese),$i=0;$i<count($tesearr);$i++ )
                <span style="color:orange;border:1px dashed orange;padding:2px 6px;font-size:14px; ">{{$tesearr[$i]}}</span>
            @endfor
            <span style="float:right;color:orange;cursor:pointer;" ><span class="glyphicon glyphicon-user" style="font-size:14px;margin-right:5px;" ></span>报名{{$detail->baoming}}人</span>
        </p>
    </div>
    <div style="color:orange;line-height:30px;position: relative;padding:10px;" >
        @if( strtotime($detail->startday) - time() > 0 )
            @if( $isjoined )
                <span style="color:#fff;font-size:16px;width:100%;display:inline-block;margin-top:20px;background:#66A466;padding:10px;">你已报名，请等待通知(一般在出发前一天)<br>确保你的手机（{{$phone}}）保持畅通</span>
            @else
                <p>
                    <a onclick="baoming({{$detail->id}})" href="javascript:void(0)" style="background: #E83888;color:#fff;display:inline-block;height:35px;text-decoration: none;cursor: pointer;width:90px;text-align: center;line-height:35px;font-size:16px;border-radius:1px;">点击报名</a><img style="height:35px;cursor:pointer;margin-left:10px;" src="/web/images/alipay.jpg" ><img style="height:33px;margin-left:10px;cursor:pointer;" src="/web/images/wxpay.png" >

                </p>
                <span class="glyphicon glyphicon-earphone" style="color:orange;height:30px;width:30px;border:2px solid orange;border-radius:15px;text-align:center;line-height:30px;margin-right:10px;" ></span>报名成功可见（短信通知里可见）
                <p style="color:#444">
                    通知说明：活动前一天发布具体分车,时间及车辆信息
                </p>

                {{--<button  type="button" class="btn btn-primary" style="width:100px;height:40px;font-size: 15px;outline:none">马上报名</button>--}}
            @endif
        @endif
    </div>
    <div style="font-size:16px;padding:10px;font-size:#333;line-height:25px;background:rgba(66,140,226,0.1);">
        <p style="height:20px;margin-top:10px;">
            活动时间：<span style="color:#4b8ee8">{{$detail->startday}}</span>
        </p>
        <p style="height:20px;">
            活动地点：<span style="color:#4b8ee8">{{$detail->mudidi}}</span>
        </p>
        <p style="height:20px;">
            交通方式：<span style="color:#4b8ee8">{{$detail->jiaotong}}</span>
        </p>
        <p style="height:20px;">
            距离：<span style="color:#4b8ee8">{{$detail->juli}}</span>
            <span style="color:orange;margin-left:10px;" >强度等级：</span><span style="color:#4b8ee8">{{$detail->qiangdu}}</span>
        </p>
        <p style="height:20px;">
            领队：<span style="color:#4b8ee8">{{$detail->leader}}</span>
            电话：<span style="color:#4b8ee8">{{$detail->phone}}</span>
        </p>

    </div>

    <div class="tubudetailnavbar" >
        <a href="#jhxx" >集合信息</a>
        <a href="#hdxq" >活动详情</a>
        <a href="#ckxc">参考行程</a>
        <a href="#ydxz">预订须知</a>
        <a href="#qtxx">其他信息</a>
        <a href="#hdly">活动留言</a>
        <a id="barbaoming" href="javascript:void(0)" onclick="baoming({{$detail->id}})" style="background: orangered;color:#fff;">马上报名</a>
        <div style="clear:both" ></div>
    </div>
    <div class="tuwen" >
        {!! $detail->tuwen !!}
    </div>
    <div id="cmbox" style="text-align:left;padding:10px;">
        <button onclick="tubucm(this,{{$detail->id}},2)"  type="button" class="btn btn-default btn-sm">
            <img src="/web/images/xihuan.png" style="height:18px;"><span style="margin-left:10px;" >点赞 ({{$detail->zancnt}})</span>
        </button>
        <textarea style="margin-top:10px;border:1px solid dodgerblue;" class="form-control"  rows="5" placeholder="评论内容..."></textarea>
        <button style="margin-top:10px;float:left  " class="btn btn-primary " onclick="tubucm(this,{{$detail->id}},1)" >提交评论</button>
    </div>
    <div style="clear:both" ></div>
    <div class="liuyanbox">

    </div>
    <div onclick="gettubucms({{$detail->id}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>

    @include("wap.footer")

@stop

@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>
        window.onscroll = function(){
            var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
            if( scrollTop>=1000 ) {

                $(".tubudetailnavbar")[0].style = "position:fixed;top:0px;width:"+$(window).width()+"px";
                $("#barbaoming").css("display","block");
            }else{
                $(".tubudetailnavbar")[0].style="";
                $("#barbaoming").css("display","none");
            }
        }
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
            gettubucms({{$detail->id}});
        });
        function baoming(id) {
            $.post("/tubu/baoming",{"tid":id},function(d){
                if( ajaxdata(d) ) {
                    toast("报名成功");
                }
            })
        }
        function tubucm(t,tid,type) {
            var content = $(t).parent("div").children("textarea").val();
            if( type == 1) {
                if( $.trim(content) == ''  ) {
                    toast("请输入评论内容"); return;
                }
            }else{
                content = 'zan';
            }
            $.post("/tubucm",{"tid":tid,"content":content,"type":type},function(d){
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
                            <div onclick="location.href='/user/${res[i].uid}'" style="display: inline-block;height:40px;width:40px;background-image:url(/head/${res[i].uid});background-size:cover;background-position:center;border-radius:20px;vertical-align: middle;float:left;cursor:pointer;margin-left:5px;" ></div>
                            <div style="font-size:14px;padding:10px;float:left;max-width:80%;margin-left:0px;border-radius:5px;">${res[i].content}</div>
                            <div style="clear:both;margin-left:55px;color:#999;" >
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