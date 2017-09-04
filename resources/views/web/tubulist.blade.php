@extends("web.common")

@section("css")
    <link rel="stylesheet" href="/web/css/index.css">
@stop

@section("body")
    @include("web.header")
    <style>
        .toppic{
            width:100%;height:335px;background-size:cover;background-position:center;background-repeat: no-repeat;
            position: relative;
        }
    </style>
    <div class="toppic" style="background-image: url(/admin/data/images/{{ count($list) == 0 ? '#' : $list[0]->pics}});" >
        @if(count($list) == 0)
            <div class='content'>
                <p style="font-size:20px;color:#999;margin-top:20px" >没有相关活动</p>
            </div>
        @endif
    </div>
    <div class="content">
        <div class="pics" >
            @for( $i=0;$i<count($list);$i++ )
                <div onclick="location.href='/tubu/tubudetail/{{$list[$i]->id}}'" class="picitem" style="background-image:url(/admin/data/images/{{$list[$i]->pictures}})">
                    <div style="width:100%;height:100%;">
                        <div style="position:absolute;bottom:10px;left:180px;height:20px;width:40px;color:#fff">                                                <img src="/web/images/love.png" style="height:20px;" alt=""><span>11</span></div>
                        <div >{{$list[$i]->title}}</div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
    <div style="clear:both" ></div>
    @include("web.footer")

@stop
