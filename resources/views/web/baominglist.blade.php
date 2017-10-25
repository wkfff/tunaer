@extends("web.common")
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
    @include("web.header")
    <div class="content">
        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="javascript:history.go(-1)">徒步活动</a>
            <span>></span>
            <a style="color: #999;text-decoration: none;cursor: default" href="javascript:void(0)" >报名列表</a>
        </div>
    <table class="table">
        <thead>
        <tr style="background:#64B5ED;color:#fff;height:50px;line-height:50px;">
            <th>昵称</th>
            <th>电话号码</th>
            <th>报名状态</th>
            <th>集合地点</th>
            <th>报名时间</th>
            <th>备注</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td><a href="/user/{{$list[$i]->uid}}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/{{$list[$i]->uid}});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle;margin-right:5px;" ></div>{{$list[$i]->uname}}</a></td>
                <td >{{substr($list[$i]->phone,0,3)."******".substr($list[$i]->phone,9,2)}}</td>
                <td>
                    @if( $list[$i]->orderid == '0' )
                        <span style="color:#666">未确认</span>
                        @else
                        <span style="color:green">已确认</span>
                    @endif
                </td>
                <td >{{$list[$i]->jihe}}</td>
                <td >{{$list[$i]->ordertime}}</td>
                <td>{{$list[$i]->mark}}</td>

            </tr>
        @endfor
        </tbody>
    </table>
    {!! $fenye !!}
    </div>
    @include("web.footer")
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