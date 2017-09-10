@extends("web.common")
@section("title","{$data->title} - 摄影大赛")

@section("css")
    <style>
         .toppic{
             width:100%;height:400px;background-size:cover;background-position:center;background-repeat: no-repeat;
             position: relative;
         }
        .jieshao{
            margin:10px 0px;
        }
        .workitem{
            width:380px;height:250px;background:deeppink;float:left;margin:10px;
            background-size:cover;background-repeat:no-repeat;
            position: relative;margin-bottom:100px;
            background-position: center;
        }
        .fengexian{
            font-size:20px;padding-bottom:10px;border-bottom:1px solid #aaa;margin:10px 0;color:#666;
            position: relative;
        }
         .searchb{
             letter-spacing: 4px;padding:6px 20px; background:#F03B6E;color:#fff;float:right;
             margin-top:-7px;margin-left:20px;border:none;outline:none;border-radius:5px;
         }
         .searchb:hover{
             opacity:0.7;color:#fff
         }
         .imgdiv{
             height:300px;width:450px;background-size:cover;margin-right:30px;
             background-position:center;background-repeat: no-repeat;margin-top:10px;
         }
        .toupiaobtn {
            float:right;background:#ff536a;width:100px;height:30px;margin-top:10px;text-align: center;line-height:30px;vertical-align: middle;border-radius:5px;margin-right:10px;cursor:pointer;
        }
        .toupiaobtn:hover{
            opacity:0.8;
        }
         .intro::after {
             content:"...";
             font-weight:bold;
             position:absolute;
             bottom:0;
             right:0;
             padding:0 20px 1px 45px;
             background:url(/web/images/ellipsis_bg.png) repeat-y;
         }
        .zhegai{
            width:380px;height:200px;background:none;position:absolute;left:0px;top:0px;cursor:pointer;
        }
        .zhegai:hover{
            background:rgba(0,0,0,0.2);
        }
    </style>
@stop
@section("body")
    @include("web.header")
    <div class="toppic" style="background-image: url(/admin/data/images/{{ $data->pic }});" ></div>
    <div class="content">
        <div style="color:orangered;font-weight:bold;margin-right:30px;font-size:20px;margin:20px 0px;">
            <span >主题：{{$data->title}}</span>

        </div>
        <div style="color:darkblue;font-weight:bold;margin-right:30px;font-size:20px;margin:20px 0px;">
            <span >时间：{{$data->startday}} - {{$data->endday}}</span>
        </div>

        <div class="fengexian">赛事介绍</div>
        <div class="jieshao">
    {!! $data->tuwen !!}
        </div>
        <div class="fengexian">
            <span>参赛作品</span>
            <span style="height:25px;width:3px;background:#ff536a;display: inline-block;vertical-align: middle;margin:0 10px;" ></span>
            <span style="color:#2562B3">
                <span >参赛作品：<span style="color:#ff536a" >{{$zongcanjia}}</span> 张</span>
                <span style="margin-left:10px;">投票次数：<span style="color:#ff536a" >{{$zongpiao}}</span> 次</span>
                <span style="margin-left:10px;">浏览次数：<span style="color:#ff536a" >{{$data->readcnt}}</span> 次</span>
            </span>
            <button onclick="canjia()" class="searchb"  >上传我的作品</button>
        </div>
        <div class="workbox" >
            @for( $i=0;$i<count($works);$i++ )
                <div class="workitem" onclick="img2big(this)"
                     style="background-image:url(/web/data/images/{{$works[$i]->pics}});">
                    <div onclick="zuzhi(event)" style="height:50px;position: absolute;width:100%;bottom:0px;background:rgba(0,0,0,0.5);color:#fff;" >
                        <div style="width:35px;height:35px;background-image:url(/head/{{$works[$i]->uid}});background-size:cover;background-position:center;border-radius:17.5px;margin:7.5px;float:left;vertical-align: middle;" ></div>
                        <div style="float:left;line-height:50px;font-size: 16px;font-weight: bold;margin-left:5px; " >
                            排名 <span style="color:orangered;margin-right:10px;">{{$i+1}}</span>
                            得票 <span style="color:#ff536a" >{{$works[$i]->depiao}}</span>
                        </div>
                        <div onclick="toupiao({{$works[$i]->id}})"  class="toupiaobtn">
                            <span style="font-size: 20px;margin-right:10px;vertical-align: middle" class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>投一票
                        </div>

                    </div>
                    <div class="zhegai" ></div>
                    <div title="{{$works[$i]->intro}}" onclick="zuzhi(event)" class="intro" style="position: absolute;bottom:-50px;width:100%;height:50px;color:#444;padding:10px 0;overflow: hidden;" >
                        {{$works[$i]->intro}}
                    </div>
                </div>
            @endfor
        </div>
        <div style="clear: both" ></div>
        {!! $fenye !!}
    </div>


    @include("web.footer")
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">参赛作品</h4>
                </div>
                <div class="modal-body">
                    <button onclick="$('.zuopin').trigger('click')" class="searchb" style="background: darkseagreen;float:left;margin-left:0px;"  >上传照片</button>
                    <input type="file" class="zuopin" onchange="uploadzuopin(this)" style="display: none;">
                    <div style="clear:both" ></div>

                    <textarea class="form-control" name="intro" style="margin-top:10px;width:450px;" rows="3" placeholder="作品介绍（不超过50字．）"></textarea>
                    <div class="zuopincurrent" ></div>
                </div>
                <div class="modal-footer">
                    <span  style="float:left" >单击图片预览</span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button onclick="save()" type="button" class="btn btn-primary">提交并参加</button>
                </div>
            </div>
        </div>
    </div>

@stop



@section("htmlend")
    <script>
        $(document).ready(function () {
//            window.tuijianleft = $(".tuijian")[0].getBoundingClientRect().left;
        })
        function canjia() {
            $("#myModal2").modal("show");
        }
        function save() {
            if( $(".zuopincurrent div").length == 0 ){
                toast("没有添加作品");return ;
            }
            var intro = $.trim( $("textarea[name=intro]").val() );
            if( intro == '' ) {
                toast("请填写作品介绍"); return;
            }
            var url = $($(".zuopincurrent div")[0]).css("background-image");
            var pic = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];
            $.post("/canjiadasai",{"pic":pic,"intro":intro,"did":"{{$data->id}}"},function(d){
                if( ajaxdata(d) ) {
                    toast("参赛成功");
                    $("#myModal2").modal("hide");
                }
            })
        }
        function uploadzuopin(t) {
            var file = t.files[0];
            if( !checkFileAllow(file,'image',10) ) {
                return false;
            }
            var fd = new FormData();
            fd.append("file" , file );
            var oXHR = new XMLHttpRequest();
            oXHR.open('POST', "/uploadimg");
            oXHR.onreadystatechange = function() {
                if (oXHR.readyState == 4 && oXHR.status == 200) {

                    $(".zuopincurrent").children().remove();
                    var d = oXHR.responseText; // 返回值
                    if( ajaxdata(d) ) {
                        var img =`<div onclick="img2big(this)" class="imgdiv"  style="background-image:url(/web/data/images/${d})" ></div>`;
                        $(".zuopincurrent").append(img);
                    }

                }
            }
            oXHR.send(fd);
        }
        function toupiao(wid) {
            $.post("/toupiao",{"wid":wid},function(d){
                if( ajaxdata(d) ) {
                    toast("投票成功,每人每天可投 3 票");
                }
            })
        }
    </script>
@stop
