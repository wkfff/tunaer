@extends("wap.common")
@section("meta")
    <meta name="theme-color" content="#6A6A6A">
@stop
@section("title","列表")
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

        <span>共计{{$count}}条数据</span>
    </div>
    <div class="content" style="margin-top:60px;" >

        <table class="table">
            <thead>
            <tr>
                <th>姓名</th>
                <th>车牌</th>
                <th>手机</th>
                <th>户口</th>
                <th>居住证</th>
                <th>代办居住证</th>
                <th>转入运营</th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < count($list); $i++)
                <tr>
                    <td class="center">{{$list[$i]->name}}</td>
                    <td class="center">{{$list[$i]->chepai}}</td>
                    <td class="center">{{$list[$i]->phone}}</td>
                    <td class="center">{{$list[$i]->pri}}-{{$list[$i]->city}}</td>
                    @if( $list[$i]->hasjuzhuzheng == 1 )
                        <td class="center">有</td>
                    @else
                        <td class="center">无</td>
                    @endif
                    @if( $list[$i]->needjuzhuzheng == 1 )
                        <td class="center">需要</td>
                    @else
                        <td class="center">不需要</td>
                    @endif
                    @if( $list[$i]->yunying == 1 )
                        <td class="center">愿意</td>
                        @else
                        <td class="center">不愿意</td>
                    @endif

                </tr>
            @endfor
            </tbody>
        </table>

        {!! $fenye !!}

    </div>
