@extends("admin.common")

@section("title","商品列表")

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>标题</th>
            <th>分类</th>
            <th>价格</th>
            <th>已售</th>
            <th>库存</th>
            <th>邮费</th>
            <th>颜色列表</th>
            <th>尺寸列表</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td><a target="_blank" style="color:cornflowerblue" href="/tubudetail/{{$list[$i]->id}}">{{$list[$i]->title}}</a></td>
                <td class="center">{{$list[$i]->sort}}</td>
                <td class="center">{{$list[$i]->price}}元</td>
                <td class="center">{{$list[$i]->sold}}件</td>
                <td class="center">{{$list[$i]->kucun}}件</td>
                <td class="center">{{$list[$i]->youfei}}元</td>
                <td class="center">{{$list[$i]->colorlist}}</td>
                <td class="center">{{$list[$i]->chicunlist}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/updateproduct/{{$list[$i]->id}}">修改</a></li>
                            <li><a href="/admin/deleteproduct/{{$list[$i]->id}}">删除</a></li>
                        </ul>
                    </li>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
@stop