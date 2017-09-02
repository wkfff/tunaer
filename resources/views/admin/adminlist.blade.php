@extends("admin.common")

@section("title","徒步活动列表")

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>编号</th>
            <th>管理</th>
            <th>等级</th>
            <th>开通时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                
                <td class="center">{{$list[$i]->id}}</td>
                <td class="center">{{$list[$i]->aname}}天</td>
                <td class="center">{{$list[$i]->adminflag}}</td>
                <td class="center">{{$list[$i]->ctime}}</td>
                <td class="center">{{$list[$i]->status}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/dongjieadmin/{{$list[$i]->id}}">冻结</a></li>
                            <li><a href="/admin/deleteadmin/{{$list[$i]->id}}">删除</a></li>
                        </ul>
                    </li>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
@stop