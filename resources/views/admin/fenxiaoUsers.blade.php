
@extends('admin.common')

@section("content")
    <div class="searchbar" style="margin-bottom:10px;">
        <input type="number" class="form-control" name="phone" placeholder="手机号">
        <select class="form-control" name="sex" style="width:150px;display: inline-block;">
            <option value="">性别 - 不限</option>
            <option value="女">女生</option>
            <option value="男">男生</option>
        </select>
        <select class="form-control" name="mryst" style="width:150px;display: inline-block;">
            <option value="">婚况 - 不限</option>
            <option value="未婚">未婚</option>
            <option value="已婚">已婚</option>
            <option value="离异">离异</option>
            <option value="丧偶">丧偶</option>
            <option value="保密">保密</option>
        </select>
        <select class="form-control" name="age" style="width:150px;display: inline-block;">
            <option value="">年龄 - 不限</option>
            <option value="1-20"><20岁</option>
            <option value="21-30">21-30岁</option>
            <option value="31-40">31-40岁</option>
            <option value="41-50">41-50岁</option>
            <option value="51-100">>51岁</option>
        </select>
        <select class="form-control" id="pro" onchange="loadC(this)" style="width:150px;display: inline-block;">
            <option value="">地区 - 省</option>
        </select>
        <select class="form-control" id="city" style="width:150px;display: inline-block;">
            <option value="">地区 - 市</option>
        </select>
        <button onclick="search()" class="btn btn-success"  >搜 索</button>
        <button onclick="location.href='/admin/fenxiao/users'" class="btn btn-primary"   >清空条件</button>
        {{--<button  class="btn btn-success" data-toggle="modal" data-target="#myModal"  >添加会员</button>--}}
    </div>
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
            <th>状态</th>
            <th>代理</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr>
                <td>{{$list[$i]->userid}}</td>
                <td class="center">{{$list[$i]->phone}}</td>
                <td class="center"><a href="/user/{{$list[$i]->userid}}">{{$list[$i]->uname}}</a></td>
                <td class="center">{{$list[$i]->sex}}</td>
                <td class="center">{{$list[$i]->age}}</td>
                <td class="center">{{$list[$i]->addr}}</td>
                <td class="center">{{$list[$i]->mryst}}</td>
                <td class="center">
                    @if( $list[$i]->status == 1 )
                        正常
                    @else
                        冻结
                    @endif
                </td>
                <td class="center">
                    @if( $list[$i]->proxy == 1 )
                        <span style="color:blue" >代理</span>
                    @else
                        <span style="color:blue" >&nbsp;</span>
                    @endif
                </td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">会员操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/monidenglu/{{$list[$i]->userid}}">登陆用户</a></li>
                            <li><a style="color:red" href="javascript:deletebyid({{$list[$i]->userid}})">删除会员</a></li>
                            <li><a href="javascript:dongjiebyid({{$list[$i]->userid}})">冻结会员</a></li>
                            <li><a href="javascript:changepasswd({{$list[$i]->userid}})">修改密码</a></li>
                            <li><a style="color:blue" href="javascript:proxy({{$list[$i]->userid}},{{$list[$i]->proxy}})">代理/取消</a></li>
                        </ul>
                    </li>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
    {!! $fenye !!}
    @if( isset($cnt) )
        <span style="margin:5px;" >总计：{{$cnt}} 条数据</span>
    @endif


    <div class="modal fade" id="myModal" style="display: none;" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加会员</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">手机号</label>
                        <input type="text" class="form-control" id="adduserphone" placeholder="手机号码">
                    </div>
                    <p>*密码默认为手机号码，稍后可修改*</p>
                    <p>其他资料可以登录用户后修改</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="adduser()">确定</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section("htmlend")
    <script src="/web/js/addr.js" ></script>
    <script>
        function adduser() {
            var phone = $("#adduserphone").val();
            if( $.trim(phone) == '' ) return;
            $.post("/admin/adduser",{"phone":$.trim(phone)},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
        function changepasswd(uid) {
            var passwd=prompt("输入新密码","");
            if( $.trim(passwd) ) {
                $.post("/admin/changepasswd",{"uid":uid,"passwd":passwd},function(d){
                    if( res = ajaxdata(d) ) {
                        toast(res);
                    }
                })
            }
        }
        function proxy(uid,proxy) {
            if( proxy == '1' )  proxy = 0;
            else proxy = 1;
            $.post("/admin/setproxy",{"uid":uid,"proxy":proxy},function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
        function loadP() {
            for( var i=0;i<pro.length;i++ ) {
                var node = "<option value='"+pro[i]+"'>"+pro[i]+"</option>";
                $("#pro").append(node);
            }
        }
        function loadC(that) {
            $("#city").children().remove();
            $("#city").append("<option value=''>地区 - 市</option>");
            var val = $(that).val();
            if( $.trim(val) != '' ) {
                var tmps = city[val];
                for( var i=0;i<tmps.length;i++ ) {
                    var node = "<option value='"+tmps[i]+"'>"+tmps[i]+"</option>";
                    $("#city").append(node);
                }
            }

        }
        function GetQueryString(name)
        {
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r!=null)
                return decodeURI(r[2]);
            return null;
        }
        $(document).ready(function(){
            loadP();
            if( GetQueryString('sex') ) {
                $("select[name=sex]").val(GetQueryString('sex'));
            }
            if( GetQueryString('phone') ) {
                $("input[name=phone]").val(GetQueryString('phone'));
            }
            if( GetQueryString('addr') ) {
                var addrs = GetQueryString('addr');
                var tmp = addrs.split("-");
                console.log(tmp);
                if( tmp.length == 1 ) {
                    $("#pro").val(tmp[0]);
                    $("#pro").trigger("change");
                }else{
                    $("#pro").val(tmp[0]);
                    $("#pro").trigger("change");
                    $("#city").val(tmp[1]);
                }
                var addr = $("#pro").val()+"-"+$("#city").val();
            }
            if( GetQueryString('mryst') ) {
                $("select[name=mryst]").val(GetQueryString('mryst'));
            }
            if( GetQueryString('age') ) {
                $("select[name=age]").val(GetQueryString('age'));
            }
        });
        function deletebyid(tid) {
            if( confirm("删除后不可恢复，确定继续？") ) {
                $.post("/admin/deletebyid",{
                    "table":"user",
                    "id":tid
                },function(data){
                    location.reload();
                })
            }

        }
        function dongjiebyid(id) {
            $.post("/admin/dongjiebyid",{
                "table":"user",
                "id":id
            },function(data){
                location.reload();
            })
        }
        function search() {
            var phone = $("input[name=phone]").val();
            var sex = $("select[name=sex]").val();
            var mryst = $("select[name=mryst]").val();
            var age = $("select[name=age]").val();
            var addr = $("#pro").val()+"-"+$("#city").val();
            if( addr == '-' ) {
                addr = '';
            }
            if( $("#pro").val() != '' && $("#city").val() == '' ) {
                addr = $("#pro").val();
            }
            var tmp = location.href.match(/page\=(\d+)/);
            if( tmp && tmp.length != 0 ) {
                page = tmp[1];
            }else{
                page = 1;
            }
            location.href="/admin/fenxiao/users?sex="+sex+"&mryst="+mryst+"&age="+age+"&addr="+addr+"&phone="+phone;
        }
    </script>
@stop