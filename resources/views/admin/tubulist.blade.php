@extends("admin.common")

@section("title","徒步活动列表")

@section("content")
    <style>
        .editpaixu:hover{
            cursor: pointer;text-decoration: underline;
        }
    </style>
    <table class="table">
        <thead>
        <tr>
            <th>排序(单击)</th>
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
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($tubulist); $i++)
            <tr>
                <td class="editpaixu" onclick="editpaixu(this,{{$tubulist[$i]->id}})" class="center">{{$tubulist[$i]->paixu}}</td>
                <td ><a target="_blank" style="color:blue;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;max-width:240px;" href="/tubu/tubudetail/{{$tubulist[$i]->id}}">{{$tubulist[$i]->title}}</a></td>
                <td >{{$tubulist[$i]->typename}}</td>
                <td style="color:green" class="center">{{$tubulist[$i]->howlong}}天</td>
                <td class="center">{{$tubulist[$i]->startday}}</td>
                <td class="center">{{$tubulist[$i]->endday}}</td>
                <td style="color:mediumvioletred" class="center">{{$tubulist[$i]->price}}元</td>
                <td class="center">{{$tubulist[$i]->need}}人</td>
                <td style="color:green" class="center">{{$tubulist[$i]->baoming}}人</td>
                <td class="center">{{$tubulist[$i]->juli}}</td>
                <td class="center">{{$tubulist[$i]->leader}}</td>
                <td class="center">{{$tubulist[$i]->visible == "1"?"显示":"隐藏"}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" onclick="copytubu({{$tubulist[$i]->id}})" >复制线路</a></li>
                            <li><a href="/admin/updatetubu/{{$tubulist[$i]->id}}">修改</a></li>
                            <li><a href="/admin/addorder/{{$tubulist[$i]->id}}">添加订单</a></li>
                            <li><a href="/admin/baominginfo/{{$tubulist[$i]->id}}">报名情况</a></li>
                            <li><a href="javascript:void(0)" onclick="visible({{$tubulist[$i]->id}})" >显示/隐藏</a></li>
                            <li><a style="color:red" href="javascript:deletebyid({{$tubulist[$i]->id}})">删除</a></li>
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
        function visible(tid) {
            $.post("/admin/tubuvisible/"+tid,{},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }

        function copytubu(tid) {
            $.post("/admin/copytubu/"+tid,{},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
        function deletebyid(tid) {
            if( confirm("删除后不可恢复，是否继续？") ) {
                $.post("/admin/deletebyid",{
                    "table":"tubuhuodong",
                    "id":tid
                },function(data){
                    location.reload();
                })
            }
        }
        function editpaixu(that,id) {

            if( paixu = prompt("请输入数字（1-100）,数字越大越靠前",parseInt($(that).text())) ) {
                if( parseInt(paixu) ) {
                    $.post("/admin/edittubupaixu",{"id":id,"paixu":parseInt(paixu)},function(d){
                        if( d== "200" ) {
                            $(that).text(parseInt(paixu));
                        }else{
                            toast("操作失败");
                        }
                    })
                }
            }
        }
    </script>
    @stop