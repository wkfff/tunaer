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
                <td class="center">{{$list[$i]->aname}}</td>
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
                            <li><a href="javascript:dongjiebyid({{$list[$i]->id}})">冻结</a></li>
                            <li><a href="javascript:void(0)" onclick="deletebyid({{$list[$i]->id}})">删除</a></li>
                        </ul>
                    </li>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
    <div>
        <button onclick="adduser()" class="btn btn-primary red" >添加管理</button>
    </div>

    <div class="modal fade" id="myModal" style="display: none;" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加管理员</h4>
                </div>
                <style>
                    #inputcls input{
                        height:30px !important;width:250px !important;border: none !important;border:1px solid #999 !important;
                    }
                    .pics div{
                        width:240px;height:150px;margin:5px;background-repeat:no-repeat;
                        float: left;background-position: center;
                        background-size:cover;
                    }

                </style>
                <div class="modal-body">
                    <div id="inputcls">
                        <input type="text" value="" placeholder="用户名" name="aname"  ><br>
                        <input type="password" value="" placeholder="密码" name="passwd"  ><br>
                        <input type="number" value="1" placeholder="等级" name="adminflag"  >(1:普通管理员,9超级管理员，其他待定)<br>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" onclick="fabu()" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section("htmlend")
    <script>
        function deletebyid(id) {
            $.post("/admin/deletebyid",{
                "table":"admin",
                "id":id
            },function(data){
                location.reload();
            })
        }
        function dongjiebyid(id) {
            $.post("/admin/dongjiebyid",{
                "table":"admin",
                "id":id
            },function(data){
                location.reload();
            })
        }
        function adduser() {
            $("#myModal").modal("show");
        }
        function fabu() {
            var aname = $("input[name=aname]").val();
            var passwd = $("input[name=passwd]").val();
            var adminflag = $("input[name=adminflag]").val();
            $.post("/admin/addadmin",{
                "aname":aname,
                "passwd":passwd,
                "adminflag":adminflag,
            },function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
    </script>
@stop