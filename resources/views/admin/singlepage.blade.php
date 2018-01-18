
@extends('admin.common')
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
                <td class="center"><a href="/single/{{$list[$i]->id}}">{{$list[$i]->title}}</a></td>
                <td class="center">/tunaer/{{$list[$i]->id}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @if( trim($list[$i]->id) != 2 )
                                <li><a href="javascript:deletebyid({{$list[$i]->id}})">删除</a></li>
                            @endif
                            <li><a href="javascript:bianji({{$list[$i]->id}})">编辑</a></li>
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
            <button onclick="tijiao()" type="button" class="btn btn-primary red" style="position:absolute;top:１0px;right:10px;" >提交保存</button>
            <input class="pagetitle" type="text" style="height:30px;width:900px;" placeholder="标题" >
            <input class="updateid" type="hidden" value="0" >
            <textarea id="editor_id" name="content" style="width:900px;height:520px;"></textarea>
        </div>
    </div>

@stop

@section("htmlend")

    <script>
        KindEditor.ready(function(K) {
            window.editor = K.create('textarea[name="content"]', {
                allowImageUpload : true
            });
        });
        function deletebyid(tid) {
            $.post("/admin/deletebyid",{
                "table":"singlepage",
                "id":tid
            },function(data){
                location.reload();
            })
        }
        function tijiao() {
            var html = window.editor.html();
            var title = $(".pagetitle").val();
            $.post("/admin/singlelpage",{
                "content":html,
                "title":title,
                "updateid":$(".updateid").val()
            },function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
        function bianji(id) {
            $.get("/admin/getsinglepage",{"id":id},function(d){
                if( data = ajaxdata(d) ) {
                    window.editor.html(data.content);
                    $(".pagetitle").val(data.title);
                    $(".updateid").val(id);
                    $(".tubupics").slideDown();
                }
            })
        }
    </script>
@stop