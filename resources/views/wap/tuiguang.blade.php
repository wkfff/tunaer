@extends("wap.common")
@section("title","我的推广")
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
            font-size:1em !important;width:100%;padding:10px;
            overflow: hidden;margin-top:10px;display:none;
        }
        .tuwen img{
            max-width:100% !important;height:auto !important;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #eee;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        <span style="max-width:180px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;line-height:55px;font-weight:bold;">推广情况</span>
        <a href="/tunaer/{{Session::get('uid')}}"><span  style="position: absolute;right:10px;top:0px;line-height:55px;font-size:14px;color:#44b5ff" >推广页面</span></a>
    </div>
    <div class="content" style="margin-top:55px;" >
        <table class="table" >
            <thead>
            <tr style="background:#64B5ED;color:#fff;height:40px;line-height:40px;">
                <th>用户</th>
                <th>&nbsp;</th>
                <th>状态</th>
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
    <div style="height:55px;width:100%;"></div>
    <div onclick="tixian()" style="height:50px;width:100%;background:#ff9046;color:#fff;text-align:center;line-height:50px;font-size:16px;position: fixed;bottom:0px;left:0px;" >申请提现( ￥<span id="tixianmoney">{{$tixian}}</span> )</div>

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