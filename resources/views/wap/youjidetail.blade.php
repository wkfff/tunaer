@extends("wap.common")
@section("title",$list->title)
@section("css")

    <style>
        .tubuitem{
            width:99%;height:200px;background-size:cover;margin:0 auto;
            background-position:center;
            background-repeat:no-repeat;margin-top:7.5px;
            /*display: inline-block;*/
            position: relative;
        }
        .tuwen{
            font-size:11px !important;width:100%;padding:5px;
            overflow: hidden;margin-top:20px;display:none;
        }
        .tuwen img{
            max-width:100% !important;height:auto !important;
        }
        .youjiuserhead{
            width:30px;height:30px;background-size:cover;background-image:url(/head/{{$list->uid}});
            background-position: center;border-radius:15px;
            display: inline-block;
            vertical-align: middle;
            background-repeat:no-repeat;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #eee;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        <span style="max-width:180px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;line-height:55px;">{{$list->title}}</span>
    </div>
    <div class="content" style="margin-top:60px;" >

        {{--<div style="font-size:22px;text-align:center;">--}}
            {{--{{$list->title}}--}}
        {{--</div>--}}

        <div style="font-size:14px;text-align:center;color:#999;margin-top:10px;">
            @if( $list->type == 2 )<span>发布者:管理员 </span>
            @else<span>发布者:{{$list->uname}} </span><a href="/user/{{$list->uid}}"><div class="youjiuserhead"  ></div></a>
            @endif
                <br>
            <span style="margin-left:10px;">发布时间:{{substr($list->ytime,0,10)}}</span>
            <span style="margin-left:10px;">阅读:{{$list->readcnt}}</span>
        </div>

        <div class="tuwen">
            {!! $list->tuwen !!}
        </div>

        <div style="padding:20px;">
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

    @include("wap.footer")

@stop
@section("htmlend")

    <script>
        $(document).ready(function () {
            window.imgUrl = $(".tuwen").find("img")[0].src;
            $(".tuwen").find("*").css("width","auto");
            $(".tuwen").find("img").css("margin","5px 0");
            $(".tuwen").find("div").css({
                "padding":"0",
                "margin":"0",
            });
//            $(".tuwen").find("img").removeAttr("onclick");
//            $(".tuwen").find("img").atttr("onclick",img2big(this));
            $(".tuwen").css("display","block");
            getyoujis({{$list->id}});
        });

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
                        var item = "<div style=\"margin:20px 0;vertical-align: middle;\">\
                            <div onclick=\"location.href='/user/"+res[i].uid+"'\" style=\"display: inline-block;height:40px;width:40px;background-image:url(/head/"+res[i].uid+");background-size:cover;background-position:center;border-radius:20px;vertical-align: middle;float:left;cursor:pointer;margin-left:5px;\" ></div>\
                            <div style=\"font-size:14px;padding:10px;float:left;max-width:80%;margin-left:0px;border-radius:5px;\">"+res[i].content+"<a href=\"javascript:void(0)\" onclick=\"huifu(this,"+res[i].id+",{{$list->id}})\">回复</a></div>\
                            <div style=\"clear:both;margin-left:55px;color:#999;\" >\
                                "+res[i].ltime+"\
                            </div>\
                        </div>";
                        $(".liuyanbox").append(item);
                        if( res[i].sub.length ) {
                            for( var j=0;j<res[i].sub.length;j++ ) {
                                var item = "<div style=\"margin:20px 0;vertical-align: middle;margin-left:40px;\">\
                            <div onclick=\"location.href='/user/"+res[i].sub[j].uid+"'\" style=\"display: inline-block;height:40px;width:40px;background-image:url(/head/"+res[i].sub[j].uid+");background-size:cover;background-position:center;border-radius:20px;vertical-align: middle;float:left;cursor:pointer;margin-left:5px;\" ></div>\
                            <div style=\"font-size:14px;padding:10px;float:left;max-width:80%;margin-left:0px;border-radius:5px;\">"+res[i].sub[j].content+"</div>\
                            <div style=\"clear:both;margin-left:55px;color:#999;\" >\
                                "+res[i].sub[j].ltime+"\
                            </div>\
                        </div>";
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
