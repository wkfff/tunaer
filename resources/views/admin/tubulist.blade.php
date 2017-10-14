@extends("admin.common")

@section("title","徒步活动列表")

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>标题</th>
            <th>类型</th>
            <th>行程</th>
            <th>出发</th>
            <th>返回</th>
            <th>价格</th>
            <th>需要多少人</th>
            <th>已报人数</th>
            <th>徒步距离</th>
            <th>领队</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($tubulist); $i++)
            <tr>
                <td><a target="_blank" style="color:cornflowerblue;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;max-width:240px;" href="/tubu/tubudetail/{{$tubulist[$i]->id}}">{{$tubulist[$i]->title}}</a></td>
                <td class="center">{{$tubulist[$i]->typename}}</td>
                <td class="center">{{$tubulist[$i]->howlong}}天</td>
                <td class="center">{{$tubulist[$i]->startday}}</td>
                <td class="center">{{$tubulist[$i]->endday}}</td>
                <td class="center">{{$tubulist[$i]->price}}元</td>
                <td class="center">{{$tubulist[$i]->need}}人</td>
                <td class="center">{{$tubulist[$i]->baoming}}人</td>
                <td class="center">{{$tubulist[$i]->juli}}</td>
                <td class="center">{{$tubulist[$i]->leader}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/updatetubu/{{$tubulist[$i]->id}}">修改</a></li>
                            <li><a href="javascript:deletebyid({{$tubulist[$i]->id}})">删除</a></li>
                        </ul>
                    </li>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
    {!! $fenye !!}
    @if( count($tubulist) == 0 )
        <div>
            <button onclick="location.href='/admin/fabutubu'" class="btn btn-primary red" >添加徒步活动</button>
        </div>
    @endif
@stop
@section("htmlend")
    <script>
        function deletebyid(tid) {
            $.post("/admin/deletebyid",{
                "table":"tubuhuodong",
                "id":tid
            },function(data){
                location.reload();
            })
        }
    </script>
    @stop