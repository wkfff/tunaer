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
                <div class="swiper-container" id="swiper-container2" style="margin-top:20px;height:140px;position:relative;">
                    <div class="swiper-wrapper">
                        @for( $imgs = explode("#",$detail->pictures),$i=0;$i<count($imgs);$i++ )
                            <div class="swiper-slide" style="background-image:url(/admin/data/images/{{$imgs[$i]}});width:100px;height:120px;"></div>
                        @endfor
                    </div>
                </div>
            </div>

            <div style="width:600px;margin-left:0px;float:left;margin-top:10px;font-size:16px;line-height: 30px;" >

                <div style="width:200px;height:50px;position:absolute;top:555px;right:0px;z-index:999;" >
                    <div style="height:30px;width:40px;background-image:url(/web/images/share.png);background-size:contain;background-repeat: no-repeat;background-position:center;position: relative;float:right;margin-left:20px;cursor:pointer;" >
                        <p style="position: absolute;bottom:-40px;line-height:30px;text-align:center;width:100%;">分享</p>
                    </div>
                    <div onclick="tubucm(this,{{$detail->id}},2)" style="height:30px;width:40px;background-image:url(/web/images/like.png);background-size:contain;background-repeat: no-repeat;background-position:center;position: relative;float:right;margin-left:20px;cursor:pointer;" >
                        <p style="position: absolute;bottom:-40px;line-height:30px;text-align:center;width:100%;">{{$detail->zancnt}}</p>
                    </div>

                    <a href="#cmbox"><div style="height:30px;width:40px;background-image:url(/web/images/comment.png);background-size:contain;background-repeat: no-repeat;background-position:center;position: relative;float:right;cursor:pointer;" >
                            <p style="position: absolute;bottom:-40px;line-height:30px;text-align:center;width:100%;color:#444">{{$detail->cmcnt}}</p>
                        </div></a>
                </div>

                <img src="/web/images/wxbaoming.jpg" style="width:100px;position: absolute;right:0px;top:420px;">

                <p style="padding-left:40px;"><span style="color:#333;font-size:20px;">{{$detail->title}}</span></p>
                <div style="height:120px;background:#FFF8EE;width:100%;color:#444;padding:10px;padding-left:40px;" >
                    <p style="border-bottom:2px dashed orange;padding-bottom:10px;line-height:35px;color:#999;font-size:16px;">活动价格：<span style="color:orange;font-size:30px;font-weight: bold;" >￥{{$detail->price}}</span><span style="color:#777;float:right;">{{str_replace("-","/",substr($detail->jiezhi,5,11))}} 截止报名</span></p>
                    <p style="line-height:35px;color:#999;font-size:16px;">
                        活动特点：
                        @for( $tesearr = explode("#",$detail->tese),$i=0;$i<count($tesearr);$i++ )
                            <span style="color:orange;border:1px dashed orange;padding:2px 6px;font-size:14px; ">{{$tesearr[$i]}}</span>
                        @endfor
                        <a href="/baominglist/{{$detail->id}}"><span style="float:right;color:orange;cursor:pointer;" ><span class="glyphicon glyphicon-th-list" style="font-size:14px;margin-right:5px;" ></span>报名列表</span></a>
                    </p>
                </div>
                <div style="padding-left:40px;" >
                    <p >
                        活动时间：<span style="color:#4b8ee8">{{$detail->startday}}</span>
                    </p>
                    <p >
                        活动地点：<span style="color:#4b8ee8">{{$detail->mudidi}}</span>
                    </p>
                    <p>
                        交通方式：<span style="color:#4b8ee8">{{$detail->jiaotong}}</span>
                    </p>
                    <p >
                        强度等级：<span style="color:#4b8ee8">{{$detail->qiangdu}}</span>
                    </p>
                    <p >
                        年龄限制：<span style="color:#4b8ee8">5 - 65岁</span>
                    </p>

                    <div style="color:orange;line-height:30px;position: relative" >

                        @if( strtotime($detail->jiezhi) - time() > 0 )
                            <p style="color:#444;">
                                支付方式：<img style="cursor:pointer;vertical-align: middle;margin-right:5px;" src="/web/tubiao/9.png" >微信支付<img style="margin-left:10px;cursor:pointer;vertical-align: middle;margin-right:5px;" src="/web/tubiao/8.png" >支付宝
                            </p>
                            @if( $isjoined )

                            <p>{!! $phone !!}</p>
                                <p style="color:#444">
                                    徒步通知说明：活动前一天发布具体分车,时间及车辆信息
                                </p>
                            @else

                                <span class="glyphicon glyphicon-earphone" style="color:orange;height:30px;width:30px;border:2px solid orange;border-radius:15px;text-align:center;line-height:30px;margin-right:10px;" ></span>报名成功可见（短信通知里可见）
                                <p style="color:#444;">
                                    徒步通知说明：活动前一天发布具体分车,时间及车辆信息
                                </p>
                                <p style="margin-top:10px;"><button onclick="openorderbox()" type="button" class="btn btn-primary" style="width:150px;height:45px;font-size: 18px;outline:none">马上报名</button></p>

                            @endif
                        @endif

                    </div>



                </div>

            </div>
            <div style="clear:both;height:20px;" ></div>
            {{--<div style="height:40px;width:100%;background:blue;color:#fff;" ></div>--}}
            <style>
                .tuwen{
                    text-align: center;width:800px;float:left;margin-top:30px;border:1px solid #efefef;
                    /*background: #efefef;*/
                }
                .tuwen img{
                    max-width:100% !important;
                }
                .tuijian{
                    float:right;width:330px;margin-top:30px;margin-left:20px;border:1px solid #eee;padding:10px;
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
                    border-top:1px solid #4B8EE8;width:1200px;text-align: left;
                    position: relative;border-bottom:1px solid #4B8EE8;
                    height:50px;line-height:50px;background: white;z-index:10;
                }
                .tubudetailnavbar a{
                    display:block;height:50px;text-decoration: none;  float:left;color:#333;
                    cursor: pointer;padding:0 30px;
                    text-align: center;
                }
                #bar_a_hover{
                    background: #4B8EE8;color:#fff;
                }
                .detailh2{
                    padding:10px;
                }
            </style>
            <div class="tubudetailnavbar" >
                <a onclick="tiaozhuan(this);bbb(this);return false;" href="#jhxx" id="bar_a_hover" >集合信息</a> 
                <a onclick="tiaozhuan(this);bbb(this);return false;" href="#ckxc">参考行程</a>
		<a onclick="tiaozhuan(this);bbb(this);return false;" href="#hdxq"  >活动详情</a>
                <a onclick="tiaozhuan(this);bbb(this);return false;" href="#ydxz">预订须知</a>
                <a onclick="tiaozhuan(this);bbb(this);return false;" href="#qtxx">其他信息</a>
                <a onclick="tiaozhuan(this);bbb(this);return false;" href="#hdly">活动留言</a>
                <a id="barbaoming" href="javascript:void(0)" onclick="openorderbox()" style="background: #4B8EE8;color:#fff;position: absolute;right:0px;display:none">马上报名</a>
                <div style="clear:both" ></div>
            </div>
            <div class="tuwen" >
                {!! $detail->tuwen !!}
                <div id="hdly"  style="margin:0px;padding:0px;border-width:1px 1px 3px;border-style:solid;border-color:#DCDCDC #DCDCDC #FF8800;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;height:40px;line-height:40px;background:#F6F5F5;position:relative;color:#666666;letter-spacing:0.5px;white-space:normal;">
                    <h2 style="margin:0px 0px 0px 20px;font-size:14px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;float:left;display:inline;color:#4F4F4F;">
                        <img style="height:20px;vertical-align: middle;" src="/web/tubiao/3.png"><span class="icon-bright" style="margin:0px 10px 0px 0px;padding:0px;border:0px;vertical-align:middle;-webkit-tap-highlight-color:transparent;background-image:url(&quot;background-repeat:no-repeat;display:inline-block;width:16px;height:16px;background-position:-217px -80px;">&nbsp;</span><span>活动留言</span>
                    </h2>
                </div>
                <div style="margin:0px 0px 15px;padding:0px 0px 6px;border-width:0px 1px 1px;border-style:solid;border-color:#DCDCDC;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;background:#F6F5F5;font-size:14px;color:#666666;letter-spacing:0.5px;white-space:normal;">
                    <div id="cmbox" style="text-align:left">

                        <textarea style="margin-top:10px;border:1px solid #ddd" class="form-control"  rows="5" placeholder="评论内容..."></textarea>
                        <button style="margin-top:10px;float:left  " class="btn btn-primary " onclick="tubucm(this,{{$detail->id}},1)" >提交评论</button>
                        <button style="margin-top:10px;margin-left:10px;" onclick="tubucm(this,{{$detail->id}},2)"  type="button" class="btn btn-default btn-sm">
                            <img src="/web/images/xihuan.png" style="height:18px;"><span style="margin-left:10px;" >点赞 ({{$detail->zancnt}})</span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="tuijian" >
                <p style="color:#999;font-size:20px;">推荐活动</p>
            </div>
            <div style="clear:both" ></div>
        </div>

    <div class="modal fade" id="myModal" style="display: none;" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">填写报名信息</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label >报名人数 <span style="color:red">*</span></label>
                        <select name="tb-num" class="form-control">
                            @for( $i=1;$i<=30;$i++  )
                                <option value="{{$i}}">{{$i}}人</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label >真实姓名 <span style="color:red">*</span></label>
                        <input class="form-control" type="text" value="" placeholder="真实姓名" name="tb-realname" >
                    </div>
                    <div class="form-group">
                        <label >联系手机 <span style="color:red">*</span></label>
                        <input class="form-control" type="text" value="" placeholder="联系号码" name="tb-mobile" >
                    </div>
                    <div class="form-group">
                        <label >身份证号 <span style="color:red">*</span></label>
                        <input class="form-control" type="text" value="" placeholder="身份证号" name="tb-idcard" >
                    </div>
                    <div class="form-group">
                        <label >选择集合地点 <span style="color:red">*</span></label>
                        <select name="tb-jihe" class="form-control">
                            @for( $data = explode("#",$detail->jihedidian),$i=0;$i<count($data);$i++  )
                                <option value="{{$data[$i]}}">{{$data[$i]}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label >订单备注 </label>
                        <textarea name="tb-mark" class="form-control"  rows="3" placeholder="添加备注..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" onclick="baoming({{$detail->id}})" class="btn btn-primary">提交报名</button>
                </div>
            </div>
        </div>
    </div>
    @include("web.footer")

@stop

@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>
        function tiaozhuan(that) {
            $("#bar_a_hover").removeAttr("id");
            $(that).attr("id","bar_a_hover");
        }
        function bbb(obj){
            location.replace(obj.href);
        }
        setTimeout(function(){
            $(".tuwen>div:nth-child(even)").css("padding","10px");
        },500)
        window.onscroll = function(){
            if( !window.tuijianleft ) {
                return ;
            }

            var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
//            console.log(scrollTop);
            if( scrollTop>=1000 ) {
                $(".tuijian")[0].style = "position:fixed;top:-30px;left:"+tuijianleft+"px";
                $(".tubudetailnavbar")[0].style = "position:fixed;top:0px;";
                @if( strtotime($detail->startday) - time() > 0 && !$isjoined )
                    $("#barbaoming").css("display","block");
                @endif

            }else{
                $(".tuijian")[0].style="";
                $(".tubudetailnavbar")[0].style="";
                $("#barbaoming").css("display","none");
            }
            var allitem = $(".tubudetailnavbar").children("a");
            for( var i=0;i<allitem.length-1;i++ ) {
                try{
                    var v = document.getElementById($(allitem[i]).attr('href').substr(1)).getBoundingClientRect().top;
                    if( v>=50 && v<=100 ) {
                        $("#bar_a_hover").removeAttr("id");
                        $(allitem[i]).attr("id","bar_a_hover");
                        break;
                    }
                }catch(e){
//                    ...
                }

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
            $.post("/tubu/baoming",{
                "tid":id,
                "realname":$("input[name=tb-realname]").val(),
                "mobile":$("input[name=tb-mobile]").val(),
                "idcard":$("input[name=tb-idcard]").val(),
                "num":$("select[name=tb-num]").val(),
                "jihe":$("select[name=tb-jihe]").val(),
                "mark":$("textarea[name=tb-mark]").val(),
            },function(d){
                if( ajaxdata(d) ) {
                    $("#myModal").modal("hide");
                    toast("报名成功，请及时付款");
                    setTimeout(function(){
                        location.href="/user/{{Session::get('uid')}}#huodong"
                    },500);
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
        function openorderbox() {
            @if( Session::get('uid') )
                location.href = "/tububaoming/{{$detail->id}}";
//                $.post("/getlastestorderinfo",{},function(d){
//                    var o = JSON.parse(d);
//                    if( o.length ) {
//                        $("input[name=tb-realname]").val(o[0].realname);
//                        $("input[name=tb-mobile]").val(o[0].mobile);
//                        $("input[name=tb-idcard]").val(o[0].idcard);
//                    }
//                    $("#myModal").modal("show");
//                })
            @else
                openlogion();
            @endif

        }
    </script>
@stop
