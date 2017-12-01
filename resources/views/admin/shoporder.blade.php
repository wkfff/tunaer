@extends("admin.common")

@section("title","商品订单列表")

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>订单号</th>
            <th>商品</th>
            <th>手机号</th>
            <th>件数</th>
            <th>快递状态(单击更改)</th>
            <th>收货地址</th>
            <th>留言</th>
            <th>颜色</th>
            <th>尺寸</th>
            <th>下单时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td  class="center">
                    @if($list[$i]->orderid == '0')
                        <span style="color:red" >未付款</span>
                    @else
                        <a style="width:100px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display: inline-block;color:green;text-decoration: underline;" href="/admin/payorder?orderid={{$list[$i]->orderid}}">{{$list[$i]->orderid}}</a>
                    @endif
                </td>
                <td title="{{$list[$i]->title}}" style="width:100px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display: inline-block;"><a target="_blank" style="color:#333" href="/shop/detail/{{$list[$i]->id}}">{{$list[$i]->title}}</a></td>
                <td class="center"><a target="_blank" style="color:cornflowerblue" href="/user/{{$list[$i]->uid}}">{{$list[$i]->phone}}</a></td>
                <td class="center">{{$list[$i]->num}}件</td>
                @if( $list[$i]->kuaidi == '0' )
                    <td class="center" id="{{$list[$i]->id}}" onclick="kuaidi(this)" style="color:orangered">等待发货</td>
                @else
                    <td class="center" id="{{$list[$i]->id}}" onclick="kuaidi(this)" style="color:green">{{$list[$i]->kuaidi}}</td>
                @endif

                <td>{{$list[$i]->addr}}</td>
                <td title="{{$list[$i]->liuyan}}" style="width:100px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display: inline-block;" >{{$list[$i]->liuyan}}</td>
                <td class="center">{{$list[$i]->color}}</td>
                <td class="center">{{$list[$i]->chicun}}</td>
                <td class="center">{{$list[$i]->otime}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            {{--<li><a href="/admin/updateproduct/{{$list[$i]->id}}">修改</a></li>--}}
                            <li><a href="javascript:void(0)" onclick="deletebyid({{$list[$i]->id}})" >删除</a></li>
                        </ul>
                    </li>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
    {!! $fenye !!}
@stop

@section("htmlend")
    <script>
        function deletebyid(id) {
            $.post("/admin/deletebyid",{
                "table":"shoporder",
                "id":id
            },function(data){
                location.reload();
            })
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