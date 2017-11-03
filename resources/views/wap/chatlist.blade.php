@extends("wap.common")
@section("meta")
    <meta name="theme-color" content="#e83888">
@stop
@section("title","好友列表")
@section("css")
    <style>
        .item{
            height:70px;width:100%;border-bottom:1px solid #eee;
            position: relative;
        }
        .head{
            height:60px;width:60px;background-size:cover;
            position: absolute;left:5px;top:5px;
            background-position:center;background-repeat: no-repeat;
        }
        .userinfo{
            padding-left:70px;height:70px;padding-top:5px;
        }
        .uname{
            font-size:16px;color:#e83888;overflow: hidden;
            text-overflow:ellipsis;white-space: nowrap;max-width:95%;
            margin-top:5px;padding-left:5px;display: block;
        }
        .message{
            font-size: 14px;color:#999;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;max-width:90%;
            padding-left:5px;display: block;margin-top:5px;
        }
        .fenye{
            margin:5px;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #eee;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;font-size:16px;" class="glyphicon glyphicon-menu-left" ></span>
        <span>好友列表</span>
    </div>
    <div class="content" style="margin-top:60px;" >
        @if( count($list) == 0 )
            <div style="padding:10px;" >
                <p>你还没有好友，<a href="/member/list">立即去找</a></p>
                <p>温馨提示：打个招呼或发一条消息你们即成为好友额</p>
            </div>
        @endif
        @for($i=0;$i<count($list);$i++)
            <a href="/chatpage/{{$list[$i]->uid}}"><div class="item">
                <div class="head" style="background-image:url(/head/{{$list[$i]->uid}})"></div>
                <div class="userinfo" >
                    <div class="uname">{{$list[$i]->uname}}</div>
                    @if( trim($list[$i]->content) == '0' )
                        @if( $list[$i]->uid == $list[$i]->fid )
                            <div class="message">Ta给我打了个招呼</div>
                        @else
                            <div class="message">我给Ta打了个招呼</div>
                        @endif
                    @else
                        <div class="message">{{$list[$i]->content}}</div>
                    @endif

                </div>
                @if($list[$i]->isread == 1 && $list[$i]->uid != $list[$i]->fid)
                <div style="position: absolute;right:10px;top:10px;border-radius:5px;
            color:#e83888;z-index:1;font-size:0.5em;" >未读</div>
                @endif
                <div style="position: absolute;right:10px;bottom:10px;font-size:0.8em;color:#888;
            z-index:1" >{{str_replace("-","/",substr($list[$i]->stime,5,11))}}</div>
            </div></a>
        @endfor
        @if( count($list) >= 60 )
                {!! $fenye !!}
        @endif

    </div>

    @include("wap.footer")


@stop

@section("htmlend")
    <script>

    </script>

@stop