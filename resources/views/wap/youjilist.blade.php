@extends("wap.common")
@section("title","徒步游记")
@section("css")

    <style>
        .tubuitem{
            width:99%;height:200px;background-size:cover;margin:0 auto;
            background-position:center;
            background-repeat:no-repeat;margin-top:7.5px;
            /*display: inline-block;*/
            position: relative;
        }
        .youjiitem{
            width:100%;height:310px;float:left;
            position: relative;
        }
        .youjipic{
            width:100%;height:220px;background-size:cover;
            background-position: center;
            background-repeat:no-repeat;
        }
        .youjiuserhead{
            width:60px;height:60px;background-size:cover;
            background-position: center;border-radius:30px;margin:0 auto;
            background-repeat:no-repeat;margin-top:-30px;background-color:#fff;
        }
        .youjititle{
            margin-top:7px;padding:0 30px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;
            text-align: center;
            font-size:18px;color:#333;
        }
        .youjitime{
            text-align: right;color:#aaa;margin-top:7px;
            font-size:13px;margin-right:20px;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #eee;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        <span>徒友游记</span>
    </div>
    <div class="content" style="margin-top:55px;" >



        @for( $i=0;$i<count($list);$i++ )
            <a href="/youji/detail/{{$list[$i]->id}}">
                <div class="youjiitem">
                    @if( $list[$i]->type == 2 )
                        <div class="youjipic" style="background-image:url(/admin/data/images/{{$list[$i]->pic}})" ></div>
                        <div class="youjiuserhead" style="background-image:url(/web/images/admin.png)" ></div>
                    @else
                        <div class="youjipic" style="background-image:url(/web/data/images/{{$list[$i]->pic}})" ></div>
                        <div class="youjiuserhead" style="background-image:url(/head/{{$list[$i]->uid}})" ></div>
                    @endif


                    <div class="youjititle">
                        {{$list[$i]->title}}
                    </div>
                    <div class="youjitime">
                        {{$list[$i]->ytime}}
                    </div>
                </div>
            </a>
        @endfor

        <div style="clear:both" ></div>
        {!! $fenye !!}
    </div>

    @include("wap.footer")

@stop

@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>
        $(document).ready(function () {
            var mySwiper = new Swiper ('.swiper-container', {
                autoplay:5000,
                loop: true,
                pagination: '.swiper-pagination'
            })
            $(".tuwen").find("*").css("width","auto");
            $(".tuwen").find("div").css({
                "padding":"0",
                "margin":"0",
            });
//            $(".tuwen img").css({
//                "height":"auto",
//            });
        });
    </script>

@stop