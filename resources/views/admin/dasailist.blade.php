
@extends('admin.common')

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>编号</th>
            <th>大赛主题</th>
            <th>图片</th>
            <th>浏览</th>
            <th>开始</th>
            <th>结束</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td>{{$list[$i]->id}}</td>
                <td class="center">{{$list[$i]->title}}</td>
                <td class="center"><div onclick="img2big(this)" style="background-image:url(/admin/data/images/{{$list[$i]->pic}});background-position:center;background-repeat:no-repeat;background-size:cover;width:30px;height:20px;" ></div></td>
                <td class="center">{{$list[$i]->readcnt}}</td>
                <td class="center">{{$list[$i]->startday}}</td>
                <td class="center">{{$list[$i]->endday}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/updatedasai/{{$list[$i]->id}}">修改</a></li>
                            <li><a href="javascript:void(0)" onclick="deletebyid({{$list[$i]->id}})">删除</a></li>
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
                "table":"dasai",
                "id":id
            },function(data){
                location.reload();
            })
        }
    </script>
@stop