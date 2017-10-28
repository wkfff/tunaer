@extends("wap.common")
@section("title","报名列表")
@section("css")

    <style>
        .imgdiv{
            height:150px;width:150px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }

        td{
            height:70px;line-height:70px;padding:0px;
        }
    </style>
@stop

@section("body")
    <div onclick="history.back()" style="width:40px;height:30px;background:rgba(0,0,0,0.3);color:#fff;position:fixed;left:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
        <span class="glyphicon glyphicon-menu-left" ></span>
    </div>
    <div class="content">

        <table class="table" >
            <thead>
            <tr style="background:#64B5ED;color:#fff;height:40px;line-height:40px;">
                <th>昵称</th>
                <th>电话</th>
                <th>状态</th>
                <th>集合</th>
                {{--<th>报名时间</th>--}}
                {{--<th>备注</th>--}}
            </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < count($list); $i++)
                <tr>
                    <td><a href="/user/{{$list[$i]->uid}}">{{$list[$i]->uname}}</a></td>
                    <td >{{substr($list[$i]->phone,0,3)."******".substr($list[$i]->phone,9,2)}}</td>
                    <td>
                        @if( $list[$i]->orderid == '0' )
                            <span style="color:#666">未确认</span>
                        @else
                            <span style="color:green">已确认</span>
                        @endif
                    </td>
                    <td >{{$list[$i]->jihe}}</td>
{{--                    <td >{{$list[$i]->ordertime}}</td>--}}
{{--                    <td>{{$list[$i]->mark}}</td>--}}

                </tr>
            @endfor
            </tbody>
        </table>
        {!! $fenye !!}
    </div>
    @include("wap.footer")
@stop


@section("htmlend")
    <script>
        function deletebyid(id) {
            $.post("/admin/deletebyid",{
                "table":"dasai",
                "id":id
            },function(data){
                location.reload();
            })
        }
    </script>
@stop