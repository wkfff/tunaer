
@extends('admin.common')

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>用户</th>
            <th>大赛</th>
            <th>作品</th>
            <th>介绍</th>
            <th>得票</th>
            <th>参赛时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td class="center"  ><a href="/user/{{$list[$i]->uid}}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/{{$list[$i]->uid}});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle;margin-right:5px;" ></div></a></td>
                <td class="center"><a href="/dasai/{{$list[$i]->did}}">{{$list[$i]->title}}</a></td>
                <td class="center"><div onclick="img2big(this)" style="background-image:url(/web/data/images/{{$list[$i]->pics}});background-position:center;background-repeat:no-repeat;background-size:cover;width:30px;height:20px;" ></div></td>
                <td class="center">{{$list[$i]->intro}}</td>
                <td class="center">{{$list[$i]->depiao}}</td>
                <td class="center">{{$list[$i]->ctime}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
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
                "table":"works",
                "id":id
            },function(data){
                location.reload();
            })
        }
    </script>
@stop