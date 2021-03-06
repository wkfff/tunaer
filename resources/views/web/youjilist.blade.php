@extends("web.common")
@section("title","游记列表")
@section("css")

    <style>
        .youjiitem{
            width:380px;height:350px;float:left;
            position: relative;margin:10px;
        }
        .youjipic{
            width:380px;height:250px;background-size:cover;
            background-position: center;
            background-repeat:no-repeat;
        }
        .youjiuserhead{
            width:80px;height:80px;background-size:cover;
            background-position: center;border-radius:40px;margin:0 auto;
            background-repeat:no-repeat;margin-top:-40px;background-color:#fff;
        }
        .youjititle{
            margin-top:7px;padding:0 30px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;
            text-align: center;
        }
        .youjitime{
            text-align: right;color:#aaa;margin-top:7px;
            font-size:14px;
        }
    </style>
@stop

@section("body")
    @include("web.header")
    <div class="content">
        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>

                @if( count($list) && $list[0]->type == 2 )
                <a style="color: #999;" href="/youjilist/2" >官方游记
                @else
                <a style="color: #999;" href="/youjilist/1" >会员游记
                @endif
            </a>
        </div>
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
    @include("web.footer")

@stop

@section("htmlend")

@stop