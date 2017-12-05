
@extends('admin.common')

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>选择</th>
            <th>联系人姓名</th>
            <th>联系电话</th>
            <th>游客信息</th>
            <th>备注</th>
            <th>集合点</th>
            <th>票价</th>
            <th>订单金额</th>
            <th>分车</th>
            <th>订单时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td style="cursor: pointer;" >
                    <span>{{$i+1}}</span>
                    <br>
                    @if( $list[$i]->orderid == '0' || strlen($list[$i]->orderid) <=5 )
                        <input disabled order_id="{{$list[$i]->id}}" type="checkbox">
                    @else
                        <input order_id="{{$list[$i]->id}}" type="checkbox">
                    @endif

                </td>
                <td class="center">{{$list[$i]->realname}}
                    @if( $list[$i]->num > 1 )
                        <span style="color:green" >[{{$list[$i]->num}}人]</span>
                    @endif
                </td>
                <td class="center">{{$list[$i]->mobile}}</td>
                <td class="center" >
                    <a href="javascript:void(0)" title="{{$list[$i]->youkes}}" style="color:green" onclick="chakan(this)">查看</a>
                </td>
                <td class="center" title="{{$list[$i]->mark}}">
                    <span style="overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;max-width:40px;">{{$list[$i]->mark}}</span>
                </td>
                <td class="center">{{$list[$i]->jihe}}</td>
                <td class="center">￥{{$list[$i]->price}}</td>

                <td class="center">
                    @if( $list[$i]->orderid == '0' || strlen($list[$i]->orderid) <=5 )
                        <span style="color:red" >未付款[￥{{$list[$i]->num*$list[$i]->price}}]</span>
                        @else
                        <span style="color:green" >已付款[￥{{isset($list[$i]->money)?$list[$i]->money:"免单支付"}}]</span>
                    @endif
                </td>
                <td class="center">
                    @if( $list[$i]->fenche == '0' )
                        <span style="color:red">未分配</span>
                        @else
                        <span style="color:green">{{$list[$i]->fenche}}号车</span>
                    @endif
                </td>
                <td class="center">{{$list[$i]->ordertime}}</td>
                <td class="center"><a href="javascript:void(0)" style="color:red" onclick="deletebyid({{$list[$i]->id}})">删除</a></td>
            </tr>
        @endfor
        </tbody>
    </table>
    <hr>
    <input class="start" type="text" placeholder="开始行" style="width:60px;border:1px solid #ccc !important;">
    <span style="margin:0 10px;">到</span>
    <input class="end" placeholder="结束行" type="text" style="width:60px;border:1px solid #ccc !important;">
    <button onclick="xuanzhong()" style="margin-left:10px;margin-top:-10px;height:30px;" class="btn btn-primary" >选中</button>
    <input class="fenchenum" type="text" placeholder="几号车" style="width:100px;border:1px solid #ccc !important;margin-left:50px;">
    @if( count($list) )
        <button onclick="fenche({{$list[0]->tid}})" style="margin-left:10px;margin-top:-10px;height:30px;" class="btn btn-success" >分车</button>
    @else
        <button onclick="fenche(0)" style="margin-left:10px;margin-top:-10px;height:30px;" class="btn btn-success" >分车</button>
    @endif
    @if( count($list) )
        <a href="/admin/exportfenche/{{$list[0]->tid}}" target="_blank"><button style="margin-left:10px;margin-top:-10px;height:30px;" class="btn btn-danger" >导出数据</button></a>
    @else
        <button onclick="toast('没有数据')" style="margin-left:10px;margin-top:-10px;height:30px;" class="btn btn-danger" >导出数据</button>
    @endif

    <span style="margin-left:50px;" >参加人数：{{$cnt}}</span>
    <span style="margin-left:50px;" >支付金额：{{$cntmoney}}</span>
    <hr>
    {!! $fenye !!}
    <hr>
    <div class="modal fade" id="myModal" style="display: none;" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">订单信息</h4>
                </div>
                <div class="modal-body">
                    <div class="youkes"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" data-dismiss="modal" class="btn btn-primary">确定</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section("htmlend")
    <script>
        function deletebyid(id) {
            if( confirm("确定要删除吗？") ) {
                $.post("/admin/deletebyid",{
                    "table":"tubuorder",
                    "id":id
                },function(data){
                    location.reload();
                })
            }
        }

        function chakan(that){
            $(".youkes").children().remove();
            $(".youkes").text('');
            var data = $(that).attr("title");
            data = JSON.parse(data);
            if(typeof data == "number") {
                $(".youkes").text(data);
            }
            for( var i=0;i<data.length;i++ ) {
                var item = `<div style="padding:5px 10px;border-bottom:1px solid #ddd;position: relative;">
                        <p>${data[i].name} TEL: ${data[i].mobile}</p>
                        <p>身份证: ${data[i].idcard}</p>
                    </div>`;
                $(".youkes").append(item);
            }
            $("#myModal").modal("show");
        }

        function xuanzhong(){
            var start = $(".start").val();
            var end = $(".end").val();
            if( !start || !end ) {
                toast("请输入开始和结束行"); return ;
            }
            var allinputs = $("input[type='checkbox']");
            for( var i=start-1;i<end;i++ ) {
                if( !$(allinputs[i]).attr("disabled") )
                    $(allinputs[i]).prop("checked",true);
            }
        }

        function fenche(tid) {
            var fenchenum = $(".fenchenum").val();
            if( !fenchenum ) {
                toast("请输入几号车"); return ;
            }
            var order_ids = new Array();
            var allinputs = $("input[type='checkbox']");
            for( var i=0;i<allinputs.length;i++ ) {
                if($(allinputs[i]).prop("checked")) {
                    order_ids.push($(allinputs[i]).attr("order_id"));
                }
            }
            if( order_ids.length == 0 ) {
                return ;
            }
            $.post("/admin/fenche",{"tid":tid,"order_ids":order_ids.join(","),"fenche":fenchenum},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
    </script>
@stop