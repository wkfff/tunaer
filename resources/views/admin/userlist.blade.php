
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
            <th>自我介绍</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($userlist); $i++)
        <tr>
            <td>{{$userlist[$i]->userid}}</td>
            <td class="center">{{$userlist[$i]->phone}}</td>
            <td class="center"><a href="/user/{{$userlist[$i]->userid}}">{{$userlist[$i]->uname}}</a></td>
            <td class="center">{{$userlist[$i]->sex}}</td>
            <td class="center">{{$userlist[$i]->age}}</td>
            <td class="center">{{$userlist[$i]->addr}}</td>
            <td class="center">{{$userlist[$i]->mryst}}</td>
            <td title="{{$userlist[$i]->intro}}" class="center">{{substr($userlist[$i]->intro,0,10)}}</td>
            <td class="center">
                <li class="dropdown user" style="list-style: none">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="username">会员操作</span>
                        <i class="icon-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/edituserinfo/{{$userlist[$i]->userid}}">修改资料</a></li>
                        <li><a href="/deleteuser/{{$userlist[$i]->userid}}">删除会员</a></li>
                    </ul>
                </li>
            </td>
        </tr>
        @endfor
        </tbody>
    </table>
@stop