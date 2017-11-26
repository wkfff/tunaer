@extends("wap.common")
@section("title","报名列表")
@section("css")

    <style>
        .imgdiv{
            height:150px;width:150px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }

        td{
            height:40px;line-height:70px;padding:0px;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:45px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:45px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:45px;" class="glyphicon glyphicon-menu-left" ></span>
        <span>报名列表</span>
    </div>
    <div class="content"  >

        <table class="table" >
            <thead>
            <tr style="background:#64B5ED;color:#fff;height:40px;line-height:40px;">
                <th>昵称</th>
                <th>状态</th>
                <th>时间</th>
                {{--<th>集合</th>--}}
                {{--<th>报名时间</th>--}}
                {{--<th>备注</th>--}}
            </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < count($list); $i++)
                <tr style="font-size:13px;">
                    <td style="text-align:center"><a style="overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;max-width:60px;margin-top:10px;" href="/user/{{$list[$i]->uid}}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/{{$list[$i]->uid}});background-size:cover;background-position:center;vertical-align: middle;margin-right:5px;" ></div></a>
                        ({{$list[$i]->num}}人)</td>
                    <td style="width:140px;line-height:40px;">
                        @if( $list[$i]->orderid == '0' )
                            <span style="color:#666">[未确认]</span>
                        @else
                            <span style="color:green">[已确认]</span>
                        @endif
                            {{substr($list[$i]->phone,0,3)."***".substr($list[$i]->phone,9,2)}}
                    </td>
                    <td style="width:90px;line-height:40px;">{{substr($list[$i]->ordertime,5,11)}}</td>
                    {{--<td >{{$list[$i]->jihe}}</td>--}}
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
