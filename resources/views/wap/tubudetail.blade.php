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
            font-size:11px !important;width:100%;
            overflow: hidden;margin-top:20px;display:none;
            background-color:#F6F5F5;
        }
        .tuwen img{
            max-width:100% !important;height:auto !important;
        }
        .tubudetailnavbar{
            width:100%;text-align: left;
            position: relative;
            line-height:40px;background: white;z-index:10;
            border-top:1px solid #ddd;
            border-bottom:1px solid #ddd;
            padding:2px 0;
        }
        .tubudetailnavbar a{
            display:block;height:40px;text-decoration: none;  float:left;color:#333;
            cursor: pointer;width:25%;
            text-align: center;
        }
        #guding{
            position:fixed;top:0px;left:0px;width:100%;
        }
        /*.tubudetailnavbar a:hover{*/
            /*background: #4B8EE8;color:#fff;*/
        /*}*/
        #bar_a_hover{
            background: #4B8EE8;color:#fff;
        }
        /*.detailh2{*/
            /*padding:10px;*/
        /*}*/
    </style>
@stop

@section("body")

    <div class="content">

        <div onclick="history.back()" style="width:40px;height:30px;background:rgba(0,0,0,0.3);color:#fff;position:fixed;left:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
            <span class="glyphicon glyphicon-menu-left" ></span>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <script> window.imgUrl = "http://www.cdtunaer.com/admin/data/images/{{explode("#",$detail->pictures)[0]}}"</script>
                @for( $imgs = explode("#",$detail->pictures),$i=0;$i<count($imgs);$i++ )
                    <div class="swiper-slide" style="background-image:url(/admin/data/images/{{$imgs[$i]}});">
                    </div>
                @endfor
            </div>
            <div class="swiper-pagination"></div>
            <div style="height:40px;position:absolute;bottom:0px;left:0px;z-index:1;background:rgba(0,0,0,0.2);padding:10px;color:#fff;width:100%;" >
                <div onclick="tubucm(this,{{$detail->id}},2)" style="height:20px;float:left;margin-left:0px;cursor:pointer;" >
                    <img src="/web/tubiao/15.png" style="height:15px;" >
                    <span>{{$detail->mudidi}}</span>
                </div>
                <div onclick="tubucm(this,{{$detail->id}},2)" style="height:20px;float:left;margin-left:10px;cursor:pointer;" >
                    <img src="/web/tubiao/13.png" style="height:15px;" >
                    <span>{{$detail->startday}}</span>
                </div>
            </div>
        </div>
    </div>
    <div style="font-size:18px;padding:10px;color:#444;font-weight:bold" >
        {{$detail->title}}
    </div>
    <div style="height:120px;background:#FFF8EE;width:100%;color:#444;padding:10px;" >
        <p style="border-bottom:2px dashed orange;padding-bottom:10px;line-height:35px;color:#999;font-size:16px;">活动价格：<span style="color:orange;font-size:30px;font-weight: bold;" >￥{{$detail->price}}</span><span style="color:#777;float:right;">{{str_replace("-","/",substr($detail->jiezhi,5,11))}} 截止报名</span></p>
        <p style="line-height:35px;color:#999;font-size:16px;">
            活动特点：
            @for( $tesearr = explode("#",$detail->tese),$i=0;$i<count($tesearr);$i++ )
                <span style="color:orange;border:1px dashed orange;padding:2px 6px;font-size:14px; ">{{$tesearr[$i]}}</span>
            @endfor
            <a style="color:#4b8ee8" href="/baominglist/{{$detail->id}}"><span style="float:right;cursor:pointer;" ><span class="glyphicon glyphicon-user" style="font-size:14px;margin-right:5px;" ></span>报名列表（{{$detail->baoming}}人）</span></a>
        </p>
    </div>
    <div style="color:orange;line-height:30px;position: relative;padding:10px;" >
        @if( strtotime($detail->startday) - time() > 0 )
            <p id="fukuanfangshi" style="color:#444;">
                支付方式：<img style="cursor:pointer;vertical-align: middle;margin-right:5px;" src="/web/tubiao/9.png" >微信支付<img style="margin-left:10px;cursor:pointer;vertical-align: middle;margin-right:5px;" src="/web/tubiao/8.png" ><span>支付宝<span>
            </p>
            @if( $isjoined )

                <p>{!! $phone !!}</p>
                <p style="color:#444">
                    {{--徒步通知说明：活动前一天发布具体分车,时间及车辆信息--}}
                    {{$detail->shuoming}}
                </p>
            @else

                {{--<span class="glyphicon glyphicon-earphone" style="color:orange;height:30px;width:30px;border:2px solid orange;border-radius:15px;text-align:center;line-height:30px;margin-right:10px;" ></span>报名成功可见（短信通知里可见）--}}
                <p style="color:#444;">
                    徒步通知说明：活动前一天发布具体分车,时间及车辆信息
                </p>
                {{--<p style="margin-top:10px;"><button onclick="openorderbox()" type="button" class="btn btn-primary" style="width:150px;height:45px;font-size: 18px;outline:none">马上报名</button></p>--}}

            @endif
        @endif
    </div>
    {{--<div style="font-size:16px;padding:10px;font-size:#333;line-height:25px;background:rgba(66,140,226,0.1);">--}}
        {{--<p style="height:20px;margin-top:10px;">--}}
            {{--活动时间：<span style="color:#4b8ee8">{{$detail->startday}}</span>--}}
        {{--</p>--}}
        {{--<p style="height:20px;">--}}
            {{--活动地点：<span style="color:#4b8ee8">{{$detail->mudidi}}</span>--}}
        {{--</p>--}}
        {{--<p style="height:20px;">--}}
            {{--交通方式：<span style="color:#4b8ee8">{{$detail->jiaotong}}</span>--}}
        {{--</p>--}}
        {{--<p style="height:20px;">--}}
            {{--强度等级：<span style="color:#4b8ee8">{{$detail->qiangdu}}</span>--}}
        {{--</p>--}}
        {{--<p style="height:20px;">--}}
            {{--年龄限制：<span style="color:#4b8ee8">5 - 65岁</span>--}}
        {{--</p>--}}

    {{--</div>--}}

    <div class="tubudetailnavbar" >
        <a onclick="tiaozhuan(this);bbb(this);return false;" style="width:33.3%" href="#jhxx" id="bar_a_hover" >行程安排</a>
        <a onclick="tiaozhuan(this);bbb(this);return false;" style="width:33.3%" href="#hdxq" >活动详情</a>
        <a onclick="tiaozhuan(this);bbb(this);return false;" style="width:33.3%" href="#ydxz" >预订须知</a>
        {{--<a onclick="tiaozhuan(this)" href="#ckxc">参考行程</a>--}}
        {{--<a onclick="tiaozhuan(this)" href="#jhxx" id="bar_a_hover" >集合信息</a>--}}
        {{--<a onclick="tiaozhuan(this)" href="#hdxq" >活动详情</a>--}}
        {{--<a onclick="tiaozhuan(this)" href="#ckxc">参考行程</a>--}}
        {{--<a onclick="tiaozhuan(this)" href="#ydxz">预订须知</a>--}}
        {{--<a onclick="tiaozhuan(this)" href="#qtxx">其他信息</a>--}}
        {{--<a onclick="tiaozhuan(this)" href="#hdly">活动留言</a>--}}
        {{--<a id="barbaoming" href="javascript:void(0)" onclick="openorderbox()" style="background: orangered;color:#fff;">马上报名</a>--}}
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
    <div class="modal fade" id="myModal" style="display: none;" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span></button>--}}
                    {{--<h4 class="modal-title" id="myModalLabel">填写报名信息</h4>--}}
                {{--</div>--}}
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
                        <textarea name="tb-mark" class="form-control"  rows="2" placeholder="添加备注..."></textarea>
                    </div>

                    <button type="button" onclick="baoming({{$detail->id}})" class="btn btn-primary">提交报名</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>

            </div>
        </div>
    </div>
    <div style="height:70px;" ></div>
    <div style="height:60px;width:100%;background:#fff;position:fixed;bottom:0px;left:0px;color:#333;z-index:999" >
        <a href="tel:18000548612"><div style="float:left;width:23%;height:60px;text-align:center;line-height:60px;position: relative;" >
            <img src="/web/tubiao/12.png" style="height:25px;margin-top:-20px;">
            <span style="color:#333;position: absolute;top:15px;left:0px;height:20px;width:100%;">报名咨询</span>
        </div></a>
        <a href="#cmbox"><div style="float:left;width:23%;height:60px;text-align:center;line-height:60px;position: relative;" >
            <img src="/web/tubiao/11.png" style="height:25px;margin-top:-20px;">
            <span style="color:#333;position: absolute;top:15px;left:0px;height:20px;width:100%;">活动留言</span>
            </div></a>

        @if( strtotime($detail->jiezhi) - time() > 0 )
            <div onclick="openorderbox()" style="float:left;width:54%;height:60px;background:#FF9531;text-align:center;line-height:60px;font-size:18px;color:#fff" >立即报名</div>
        @else
            <div style="float:left;width:54%;height:60px;background:grey;text-align:center;line-height:60px;font-size:18px;color:#fff" >活动已结束</div>
        @endif


    </div>

@stop

@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>
        $(document).ready(function(){
            if(is_weixn()) {
                $($("#fukuanfangshi").children("img")[1]).remove();
		        $("#fukuanfangshi").children("span").remove();
            }
        })
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
//            var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
            var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
            if( scrollTop>=750 ) {
                $(".tubudetailnavbar").attr("id","guding");
//                $(".tubudetailnavbar")[0].style = "position:fixed;top:0px;left:0px;width:"+$(window).width()+"px";
            }else{
                $(".tubudetailnavbar").removeAttr("id");
                $(".tubudetailnavbar")[0].style="";
            }
            var allitem = $(".tubudetailnavbar").children("a");
            for( var i=0;i<allitem.length;i++ ) {
                try{
                    var v = document.getElementById($(allitem[i]).attr('href').substr(1)).getBoundingClientRect().top;
                    if( v>=50 && v<=100 ) {
                        $("#bar_a_hover").removeAttr("id");
                        $(allitem[i]).attr("id","bar_a_hover");
                        break;
                    }
                }catch(e){

                }

            }
        }
        $(document).ready(function () {
            window.desc = $.trim($("#hdxq").next().text()).substr(0,100).replace(/[\r\n\s]/g,"");
            var mySwiper = new Swiper ('.swiper-container', {
                autoplay:5000,
                loop: true,
                pagination: '.swiper-pagination'
            })
            $(".tuwen").find("*").css("width","auto");
            $(".tuwen").find("img").removeAttr("style");
            $(".tuwen").find("img").css("margin","5px 0");
            $(".tuwen").find("div").css({
                "padding":"0",
                "margin":"0",
            });
            $(".tuwen").css("display","block");
            gettubucms({{$detail->id}});
            setTimeout(function(){
                $("#jhxx")[0].childNodes[1].childNodes[3].remove()
                $("#jhxx").children("h2").append("<span>集合信息</span>");
            },200);
        });
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
                        var item = "<div style=\"margin:20px 0;vertical-align: middle;\"> <div onclick=\"location.href='/user/"+res[i].uid+"'\" style=\"display: inline-block;height:40px;width:40px;background-image:url(/head/"+res[i].uid+");background-size:cover;background-position:center;border-radius:20px;vertical-align: middle;float:left;cursor:pointer;margin-left:5px;\"></div> <div style=\"font-size:14px;padding:10px;float:left;max-width:80%;margin-left:0px;border-radius:5px;\">"+res[i].content+"<a href=\"javascript:void(0)\" onclick=\"huifu(this,"+res[i].id+",{{$detail->id}})\">回复</a></div> <div style=\"clear:both;margin-left:55px;color:#999;\"> "+res[i].ctime+" </div> </div>";
                        $(".liuyanbox").append(item);
                        if( res[i].sub.length ) {
                            for( var j=0;j<res[i].sub.length;j++ ) {
                                var item = "<div style=\"margin:20px 0;vertical-align: middle;margin-left:40px;\"> <div onclick=\"location.href='/user/"+res[i].sub[j].uid+"'\" style=\"display: inline-block;height:40px;width:40px;background-image:url(/head/"+res[i].sub[j].uid+");background-size:cover;background-position:center;border-radius:20px;vertical-align: middle;float:left;cursor:pointer;margin-left:5px;\"></div> <div style=\"font-size:14px;padding:10px;float:left;max-width:80%;margin-left:0px;border-radius:5px;\">"+res[i].sub[j].content+"</div> <div style=\"clear:both;margin-left:55px;color:#999;\"> "+res[i].sub[j].ctime+" </div> </div>";
                                $(".liuyanbox").append(item);
                            }
                        }
                    }
                }
            })
        }
        function huifu(that,pid,tid) {
            if( content = prompt("输入回复内容","") ) {
                $.post("/tubusubcomment",{"pid":pid,"content":content,"tid":tid},function(d){
                    if( ajaxdata(d) ) {
                        location.reload();
                    }
                })
            }
        }
    </script>

@stop
