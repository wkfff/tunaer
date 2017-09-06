
@extends('admin.common')

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>编号</th>
            <th>手机</th>
            <th>昵称</th>
            <th>性别</th>
            <th>年龄</th>
            <th>地址</th>
            <th>婚况</th>
            <th>状态</th>
            {{--<th>自我介绍</th>--}}
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
        <tr>
            <td>{{$list[$i]->userid}}</td>
            <td class="center">{{$list[$i]->phone}}</td>
            <td class="center"><a href="/user/{{$list[$i]->userid}}">{{$list[$i]->uname}}</a></td>
            <td class="center">{{$list[$i]->sex}}</td>
            <td class="center">{{$list[$i]->age}}</td>
            <td class="center">{{$list[$i]->addr}}</td>
            <td class="center">{{$list[$i]->mryst}}</td>
            <td class="center">
                @if( $list[$i]->status == 1 )
                    正常
                    @else
                    冻结
                @endif
            </td>
            {{--<td title="{{$list[$i]->intro}}" class="center">{{substr($list[$i]->intro,0,10)}}</td>--}}
            <td class="center">
                <li class="dropdown user" style="list-style: none">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="username">会员操作</span>
                        <i class="icon-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/monidenglu/{{$list[$i]->userid}}">登陆用户</a></li>
                        <li><a href="javascript:deletebyid({{$list[$i]->userid}})">删除会员</a></li>
                        <li><a href="javascript:dongjiebyid({{$list[$i]->userid}})">冻结会员</a></li>
                    </ul>
                </li>
            </td>
        </tr>
        @endfor
        </tbody>
    </table>
@stop

@section("htmlend")
    <script>
        function deletebyid(tid) {
            $.post("/admin/deletebyid",{
                "table":"user",
                "id":tid
            },function(data){
                location.reload();
            })
        }
        function dongjiebyid(id) {
            $.post("/admin/dongjiebyid",{
                "table":"user",
                "id":id
            },function(data){
                location.reload();
            })
        }
    </script>
@stop