@extends("admin.common")

@section("title","体现申请列表")

@section("content")
    <style>
        .editpaixu:hover{
            cursor: pointer;text-decoration: underline;
        }
    </style>
    <table class="table">
        <thead>
        <tr>
            <th>申请人</th>
            <th>联系电话</th>
            <th>申请时间</th>
            <th>提现金额</th>
            <th>处理情况</th>
            <th>推广情况</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td class="center">
                    <a href="/user/{{$list[$i]->uid}}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/{{$list[$i]->uid}});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle;margin-right:5px;" ></div></a>
                </td>
                <td class="center">{{$list[$i]->mobile}}</td>
                <td style="color: #ff3caa;" class="center">{{$list[$i]->stime}}</td>
                <td class="center">¥ {{$list[$i]->money}}</td>
                <td style="color:red" class="center">
                    @if($list[$i]->done == 0)
                        未转账
                    @else
                        <span style="color:green" >已转账</span>
                    @endif
                </td>
                <td class="center">
                        <a target="_blank" style="color:#205cff" href="/admin/tuiguang/{{$list[$i]->uid}}">点击查看</a>
                </td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        @if( $list[$i]->done == 0 )
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" onclick="dotixian({{$list[$i]->id}},{{$list[$i]->uid}})" >已转账</a></li>
                        </ul>
                        @endif
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
        function dotixian(id) {
            if( confirm("确认已经处理了吗？此操作不可逆") ){
                $.post("/admin/dotixian/",{"id":id},function(d){
                    if( ajaxdata(d) ) {
                        location.reload();
                    }
                })
            }

        }
    </script>
@stop