@extends("admin.common")

@section("title","徒步订单列表")

@section("content")
    <div class="searchbar" style="margin-bottom:10px;">
        <form action="/admin/payorder" method="GET">
            <input type="text" class="form-control" name="orderid" style="height:30px;width:300px;" placeholder="订单号">
            <button type="submit" class="btn btn-success"  style="margin-top:-10px;margin-left:10px;" >搜 索</button>
        </form>

    </div>
    <table class="table">
        <thead>
        <tr>
            <th>编号</th>
            <th>订单号</th>
            <th>支付金额</th>
            <th>支付类型</th>
            <th>支付时间</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td class="center">{{$list[$i]->id}}</td>
                <td class="center">{{$list[$i]->orderid}}</td>
                <td class="center">{{$list[$i]->money}}</td>
                <td class="center" style="color:green">
                    @if( $list[$i]->paytype == 'wxpay_saoma' )
                        微信扫码支付
                    @elseif( $list[$i]->paytype == 'wxpay_wap' )
                        微信手机支付
                    @elseif( $list[$i]->paytype == 'wxpay_wxwap' )
                        微信公众号支付
                    @elseif( $list[$i]->paytype == 'alipay_wap' )
                        支付宝手机
                    @elseif( $list[$i]->paytype == 'alipay_pc' )
                        支付宝电脑
                    @else
                        <span style="color:red" >未知</span>
                    @endif
                </td>
                <td class="center">{{$list[$i]->ptime}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
    {!! $fenye !!}
@stop

@section("htmlend")
    <script>
        function deletebyid(id) {
            if (confirm("删除后不可恢复，是否继续？")) {
                $.post("/admin/deletebyid", {
                    "table": "tubuorder",
                    "id": id
                }, function (data) {
                    location.reload();
                })
            }
        }

        function kuaidi(that) {
            if( n = prompt("更快快递状态",$(that).text()) ) {
                var id = $(that).attr("id");
                $.post("/admin/updatekuaidi",{
                    "id":id,
                    "kuaidi":n
                },function(d){
                    if( ajaxdata(d) ) {
                        $(that).text(n);
                        $(that).css("color","green");
                        toast("修改成功");
                    }
                })
            }
        }
    </script>
@stop