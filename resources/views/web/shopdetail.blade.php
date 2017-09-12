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
        .tb-booth{border:1px solid #CDCDCD;position:relative;z-index:1;}
        .tb-thumb .tb-selected{border:1px solid #C30008 ;height:40px;}
        .tb-thumb .tb-selected div{background-color:#FFFFFF;border:medium none;}
        .tb-thumb li div{border:1px solid #CDCDCD;}
        .zoomDiv{z-index:999;position:absolute;top:0px;left:0px;width:200px;height:200px;background:#ffffff;border:1px solid #CCCCCC;display:none;text-align:center;overflow:hidden;}
        .zoomMask{position:absolute;background:url("/web/images/mask.png") repeat scroll 0 0 transparent;cursor:move;z-index:1;}
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
                            {{--<a href="javascript:void(0)"><img src="/admin/data/images/{{$imgs[$i]}}" ></a></div>--}}
                    </li>
                @endfor

            </ul>
        </div>
        <div class="shopinfo" style="margin-top:20px;height:300px;float:left;width:760px;height:420px;" >
            <div style="font-size:16px;color:#3C3C3C;font-weight:700;line-height:30px;max-width:500px;">
                {{$detail->title}}
            </div>
            <div style="height:90px;width:500px;background:#ddd;" ></div>
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