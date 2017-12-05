@extends("admin.common")

@section("title","徒步订单列表")

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>订单号</th>
            <th>活动</th>
            <th>真实姓名</th>
            <th>人数</th>
            <th>集合点</th>
            {{--<th>详情</th>--}}
            <th>手机号</th>
            <th>备注</th>
            {{--<th>件数</th>--}}
            {{--<th>快递状态</th>--}}
            {{--<th>收货地址</th>--}}
            {{--<th>留言</th>--}}
            {{--<th>颜色</th>--}}
            {{--<th>尺寸</th>--}}
            <th>报名时间</th>
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
                <td title="{{$list[$i]->title}}" ><a target="_blank" style="width:200px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display: inline-block;color:#333" href="/shop/detail/{{$list[$i]->id}}">{{$list[$i]->title}}</a></td>
                <td class="center"><a target="_blank" style="color:orangered" href="/user/{{$list[$i]->uid}}">{{$list[$i]->realname}}</a></td>
                <td class="center">{{$list[$i]->num}}</td>
                <td class="center">{{$list[$i]->jihe}}</td>
{{--                <td class="center">{{$list[$i]->youkes}}</td>--}}
                <td class="center">{{$list[$i]->mobile}}</td>
                <td class="center" title="{{$list[$i]->mark}}" ><div style="width:100px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display: inline-block;" >{{$list[$i]->mark}}</div></td>

                <td class="center">{{$list[$i]->ordertime}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" onclick="miandan({{$list[$i]->id}})">免单</a></li>
                            <li><a style="color:red" href="javascript:void(0)" onclick="deletebyid({{$list[$i]->id}})" >删除</a></li>
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
            if (confirm("删除后不可恢复，是否继续？")) {
                $.post("/admin/deletebyid", {
                    "table": "tubuorder",
                    "id": id
                }, function (data) {
                    location.reload();
                })
            }
        }

        function miandan(id) {
            $.post("/admin/tubumiandan",{"id":id},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
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