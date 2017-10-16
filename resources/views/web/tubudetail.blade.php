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
            {{--<div style="color:#4b8ee8;font-size:24px;">--}}
                {{--{{$detail->title}}--}}
            {{--</div>--}}
            <div style="float: left;margin-top:10px;">
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
            </div>

            <div style="width:600px;margin-left:0px;float:left;margin-top:10px;font-size:16px;line-height: 30px;" >
                <p style="padding-left:40px;"><span style="color:#333;font-size:20px;">{{$detail->title}}</span></p>
                <div style="height:120px;background:#FFF8EE;width:100%;color:#444;padding:10px;padding-left:40px;" >
                    <p style="border-bottom:2px dashed orange;padding-bottom:10px;line-height:35px;color:#999;font-size:16px;">活动价格：<span style="color:orange;font-size:30px;font-weight: bold;" >￥{{$detail->price}}</span><span style="color:#777;float:right;">{{$detail->startday}} 截止报名</span></p>
                    <p style="line-height:35px;color:#999;font-size:16px;">
                        @if( !$isjoined )
                            活动特点：
                            @for( $tesearr = explode("#",$detail->tese),$i=0;$i<count($tesearr);$i++ )
                                <span style="color:orange;border:1px dashed orange;padding:2px 6px;font-size:14px; ">{{$tesearr[$i]}}</span>
                            @endfor
                            <span style="float:right;color:orange;cursor:pointer;" ><span class="glyphicon glyphicon-list" style="font-size:14px;margin-right:5px;" ></span>报名列表</span>
                        @endif
                        {{--@if( strtotime($detail->startday) - time() > 0 )--}}
                                {{--@if( $isjoined )--}}
                                    {{--<span style="color:red;font-size:16px;">你已报名，请等待通知(出发前一天)，确保你的{{$phone}}保持畅通</span>--}}
                                    {{--@else--}}
                                    {{--<span style="float:right" ><button onclick="baoming({{$detail->id}})" type="button" class="btn btn-warning" style="width:150px;height:40px;font-size: 20px;outline:none">马上报名</button></span>--}}
                                    {{--@endif--}}
                            {{--@endif--}}

                    </p>
                </div>
                <div style="padding-left:40px;" >
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
                    <p>
                        支付方式：<img style="height:40px;cursor:pointer;" src="/web/images/alipay.jpg" ><img style="height:35px;margin-left:10px;cursor:pointer;" src="/web/images/wxpay.png" >
                    </p>
                    <div style="color:orange;line-height:30px;position: relative" >
                        <span class="glyphicon glyphicon-earphone" style="color:orange;height:30px;width:30px;border:2px solid orange;border-radius:15px;text-align:center;line-height:30px;margin-right:10px;" ></span>报名成功可见（短信通知里可见）
                    <p style="color:#444">
                        徒步通知说明：活动前一天发布具体分车,时间及车辆信息
                    </p>
                        <img src="/web/images/wxbaoming.jpg" style="width:100px;position: absolute;right:0px;bottom:0px;">
                    </div>

                    <div style="position:relative;">
                        <button onclick="baoming({{$detail->id}})" type="button" class="btn btn-primary" style="width:150px;height:45px;font-size: 18px;outline:none">马上报名</button>
                        <div style="width:200px;height:50px;position:absolute;top:0px;right:0px;" >

                            <div style="height:30px;width:40px;background-image:url(/web/images/share.png);background-size:contain;background-repeat: no-repeat;background-position:center;position: relative;float:right;margin-left:20px;cursor:pointer;" >
                                <p style="position: absolute;bottom:-40px;line-height:30px;text-align:center;width:100%;">20</p>
                            </div>
                            <div style="height:30px;width:40px;background-image:url(/web/images/like.png);background-size:contain;background-repeat: no-repeat;background-position:center;position: relative;float:right;margin-left:20px;cursor:pointer;" >
                                <p style="position: absolute;bottom:-40px;line-height:30px;text-align:center;width:100%;">20</p>
                            </div>

                            <div style="height:30px;width:40px;background-image:url(/web/images/comment.png);background-size:contain;background-repeat: no-repeat;background-position:center;position: relative;float:right;cursor:pointer;" >
                                <p style="position: absolute;bottom:-40px;line-height:30px;text-align:center;width:100%;">20</p>
                            </div>

                        </div>
                    </div>
                    {{--@for( $data = explode("#",$detail->jihedidian),$i=0;$i<count($data);$i++  )--}}
                        {{--<p>--}}
                            {{--集合地点{{($i+1)}}：<span style="color:#4b8ee8">{{$data[$i]}}</span>--}}
                        {{--</p>--}}
                    {{--@endfor--}}
                </div>

            </div>
            <div style="clear:both;height:20px;" ></div>
            <style>
                .tuwen{
                    text-align: center;width:800px;float:left;margin-top:30px;border:1px solid #efefef;padding:10px;
                    background: #efefef;
                }
                .tuwen img{
                    max-width:100% !important;
                }
                .tuijian{
                    float:left;width:330px;margin-top:30px;margin-left:20px;border:1px solid #eee;padding:10px;
                    z-index:9;
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
                    border-top:1px solid blue;width:1200px;text-align: left;
                    position: relative;
                    height:50px;line-height:50px;background: white;z-index:10;
                }
                .tubudetailnavbar a{
                    display:block;height:50px;text-decoration: none;  float:left;color:#333;
                    cursor: pointer;padding:0 30px;
                    text-align: center;
                }
                .tubudetailnavbar a:hover{
                    background: #4B8EE8;color:#fff;
                }
            </style>
            <div class="tubudetailnavbar" >
                <a href="#jhxx" >集合信息</a>
                <a href="#hdxq" style="background: #4B8EE8;color:#fff;">活动详情</a>
                <a href="#ckxc">参考行程</a>
                <a href="#ydxz">预订须知</a>
                <a href="#qtxx">其他信息</a>
                <a href="#hdly">活动留言</a>
                <a id="barbaoming" href="javascript:void(0)" onclick="baoming({{$detail->id}})" style="background: orange;color:#fff;position: absolute;right:0px;display:none">马上报名</a>
                <div style="clear:both" ></div>
            </div>
            <div class="tuwen" >
                <div>{!! $detail->tuwen !!}</div>

                <div >
                    <button onclick="youjicm(this,{{$list->id}},2)"  type="button" class="btn btn-default btn-sm">
                        <img src="/web/images/xihuan.png" style="height:18px;"><span style="margin-left:10px;" >点赞 ({{$list->zancnt}})</span>
                    </button>
                    <textarea style="margin-top:10px;border:1px solid dodgerblue" class="form-control"  rows="5" placeholder="评论内容..."></textarea>
                    <button style="margin-top:10px;float:left  " class="btn btn-primary " onclick="tubucm(this,{{$detail->id}})" >提交评论</button>
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
            if( scrollTop>=1000 ) {
                $(".tuijian")[0].style = "position:fixed;top:-30px;left:"+tuijianleft+"px";
                $(".tubudetailnavbar")[0].style = "position:fixed;top:0px;";
                $("#barbaoming").css("display","block");
            }else{
                $(".tuijian")[0].style="";
                $(".tubudetailnavbar")[0].style="";
                $("#barbaoming").css("display","none");
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