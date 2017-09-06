@extends("web.common")
@section("title","徒步资讯")
@section("css")
    <style>
        .zixunitem{
            height:200px;width:800px;line-height:25px;
        }
        .left{
            float:left;width:250px;height:160px;
            background-size:cover;margin-top:20px;margin-left:20px;
            background-position: center;cursor: pointer;
            background-repeat:no-repeat;
        }
        .left:hover{
            opacity:0.8;
        }
        .right{
            float:left;width:500px;height:200px;padding:20px;color:#444;
        }
        .right>.title{
            font-weight:bold;margin-bottom:10px;font-size:16px;margin-top:5px;
            cursor: pointer;
        }
        .right>.title:hover{
            text-decoration: underline;
        }
        .right>.info{
            color:#999;font-size:14px;margin-bottom:10px;
        }
        .right>.jianjie{
            line-height:25px;max-height:75px;overflow: hidden;display:none;
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
            @for( $i=0;$i<count($list);$i++ )
            <div class="zixunitem">
                <div class="left" style="background-image:url(/admin/data/images/{{$list[$i]->pic}});"></div>
                <div class="right">
                    <div class="title">{{$list[$i]->title}}</div>
                    <div class="info"><span>发布者:管理员 </span><span style="margin-left:10px;">发布时间:{{$list[$i]->ptime}}</span><span style="margin-left:10px;">阅读:{{$list[$i]->readcnt}}</span></div>
                    <div class="jianjie">
                    {!!$list[$i]->tuwen!!}
                    </div>
                </div>
            </div>
            @endfor
            <div style="clear:both" ></div>
        </div>
    @include("web.footer")

@stop

@section("htmlend")
    <script>
        function removeHTMLTag(str) {
            str = str.replace(/<\/?[^>]*>/g,''); //去除HTML tag
            str = str.replace(/[ | ]*\n/g,'\n'); //去除行尾空白
            //str = str.replace(/\n[\s| | ]*\r/g,'\n'); //去除多余空行
            str=str.replace(/&nbsp;/ig,'');//去掉&nbsp;
            return str;
        }
        $(document).ready(function(){
            var jianjies = $(".jianjie");
            for( var i=0;i<jianjies.length;i++ ) {
                var tmp = (String($(jianjies[i]).text())).substr(0,200);
                $(jianjies[i]).text(tmp);
            }
            $(".jianjie").css("display","block");
        })
    </script>
@stop