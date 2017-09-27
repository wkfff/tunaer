
@extends('admin.common')
<link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">
@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>编号</th>
            <th>标题</th>
            <th>链接</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td>{{$list[$i]->id}}</td>
                <td class="center">{{$list[$i]->title}}</td>

                {{--<td title="{{$list[$i]->intro}}" class="center">{{substr($list[$i]->intro,0,10)}}</td>--}}
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:deletebyid({{$list[$i]->id}})">删除</a></li>
                            <li><a href="javascript:dongjiebyid({{$list[$i]->id}})">编辑</a></li>
                        </ul>
                    </li>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
    <div>
        <button onclick="$('.tubupics').slideDown()" class="btn btn-primary red" >添加 +</button>
    </div>

    <div class="tubupics" onclick="$(this).slideUp()" style="width:100%;height: 100%;position:fixed;z-index:9999;left:0px;top:0px;display:none" >

        <div onclick="zuzhi(event)" style="width:1000px;height:570px;background:white;position:absolute;top:50%;left:50%;
        margin-left:-500px;margin-top:-285px;box-shadow:1px 3px 15px rgba(0,0,0,0.8);overflow-y: auto;padding:10px;  " >
            <button onclick="$('.tubupics').slideUp();" type="button" class="btn btn-primary red" style="position:absolute;top:１0px;right:10px;" >提交保存</button>
            <script type="text/plain" id="myEditor" style="width:900px;"></script>
        </div>
    </div>

@stop

@section("htmlend")
    <script src="/admin/umediter/umeditor.config.js" ></script>
    <script src="/admin/umediter/umeditor.min.js" ></script>

    <script>
        window.um = UM.getEditor('myEditor');
        function deletebyid(tid) {
            $.post("/admin/deletebyid",{
                "table":"user",
                "id":tid
            },function(data){
                location.reload();
            })
        }
    </script>
@stop