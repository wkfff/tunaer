@extends("wap.common")
@section("title","推广情况")
@section("css")

    <style>
        .fenye{
            margin:10px;
        }
        .fenye a {
            display:inline-block;height:25px;padding:0px 10px;
            text-align: center;color:#fff;background:#E83888;
            font-size:14px;line-height:25px;margin:0px 2px;
            text-decoration: none;border:none;
        }
        .fenyecurrent{
            background: #eee !important;color:#6d643c!important;cursor:default !important;
        }
    </style>
@stop

@section("body")
    <div style="width:500px;margin:0 auto">
    <h3 style="margin-top:15px;">可用提现金额( ￥<span id="tixianmoney">{{$tixian}}</span> )</h3>
    <div class="content" style="margin-top:15px;" >
        <table class="table" >
            <thead>
            <tr style="background:#64B5ED;color:#fff;height:40px;line-height:40px;">
                <th>用户</th>
                <th>状态</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < count($list); $i++)
                @for( $youkes=json_decode($list[$i]->youkes),$j=0;$j<count($youkes);$j++ )
                    <tr style="background: {{$i%2 == 0 ? "#eee":"#fff"}}">
                        <td style="width:40px;">
                            @if( $j == 0 )
                                <a href="/user/{{$list[$i]->uid}}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/{{$list[$i]->uid}});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle;margin-right:5px;" ></div></a>
                            @endif
                        </td>
                        <td style="line-height:40px;">
                            {{mb_substr($youkes[$j]->name,0,1)."***"}}
                            ({{substr($list[$i]->mobile,0,3)."***".substr($list[$i]->mobile,9,2)}})
                        </td>
                        <td style="line-height:40px;">
                            {{str_replace('-','/',substr($list[$i]->ordertime,5,5))}}
                            @if( $j == 0 )
                                @if( $list[$i]->orderid == '0' || $list[$i]->money==''  )
                                    <span style="color:#666">&nbsp;</span>
                                @else
                                    @if( $list[$i]->tixian == '1' )
                                        <span style="color:#58c93b">&nbsp;￥{{$list[$i]->money}}【已提】</span>
                                    @else
                                        <span style="color:#ff9046">&nbsp;￥{{$list[$i]->money}}</span>
                                    @endif

                                @endif
                            @endif
                        </td>

                    </tr>
                @endfor
            @endfor
            </tbody>
        </table>

    </div>
    {!! $fenye !!}
@stop

@section("htmlend")
    <script>
        function tixian() {
            var tmp = parseInt($("#tixianmoney").text());
            if( tmp < 10 ) {
                toast("单次体现金额需大于 ¥ 10"); return;
            }
            var phone = prompt("请填写你的联系手机号","");
            if( /^1[0-9]{10}$/.test(phone) ) {
                $.post("/tixian",{
                    "phone":phone
                },function(d){
                    if(res = ajaxdata(d)) {
                        toast(res);
                    }
                })
            }else{
                toast("请填写正确的手机号码");
            }

        }
    </script>
@stop