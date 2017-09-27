@extends("wap.common")
@section("title","徒友交流")
@section("css")
    <style>
        select{
            letter-spacing:2px;
        }
        .userlist{
            width:100%;height:100px;margin-top:20px;
        }
        .useritem{
            height:260px;width:100%;position: relative;background-position:center;background-size:cover;background-repeat:no-repeat;float:left;margin-right:20px;margin-bottom:120px;cursor: pointer;
        }
        /*.useritem:hover{*/
        /*opacity:0.9;*/
        /*}*/
        .useritem div{
            position:absolute;bottom:-110px;height:110px;line-height:28px;color:#444;
            font-size:16px;letter-spacing: 2px;padding:10px;width:100%;
        }
        .lianjie{
            height:260px;width:100%;position: absolute;left:0px;top:0px;
        }
        select{
            width:100% !important;margin-left:0%;margin-top:5px;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        <span data-toggle="modal" data-target="#myModal2" style="float:left;position: absolute;right:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-search" ></span>
        <span>徒友列表</span>
    </div>

    <div class="content" style="margin-top:60px;" >

        <div style="clear:both" ></div>
        <div class="userlist">
            @for( $i=0;$i<count($list);$i++ )
                <div  class="useritem" style="background-image:url(/head/{{$list[$i]->userid}});">
                    <i onclick="location.href='/user/{{$list[$i]->userid}}'" class="lianjie" ></i>
                    <div>
                        <a href="/user/{{$list[$i]->userid}}">
                            @if( trim($list[$i]->uname) == '' )
                                <span>Ta很懒,竟未填写</span>
                            @else
                                <span style="overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;max-width:90%;float:left">{{$list[$i]->uname}}</span>
                            @endif
                        </a>
                        @if( $list[$i]->sex == '男' )
                            <img src="/web/images/male.png" style="height:18px;margin-left:5px;vertical-align: middle">
                        @else
                            <img src="/web/images/female.png" style="height:18px;margin-left:5px;vertical-align: middle">
                        @endif
                        <p onclick="zuzhi(event);">
                            <span>年龄：{{$list[$i]->age}}岁</span>
                            <span>婚况：{{$list[$i]->mryst}}</span>
                            <span style="display:block">
                            <a target="_blank" href="/monilogin/{{$list[$i]->userid}}"><span>地区：{{$list[$i]->addr}}</span></a>
                            <button onclick="zhaohu({{$list[$i]->userid}})" class="btn btn-xs btn-danger" style="background:#e83888;border:none;outline:none;position:absolute;top:20px;right:20px;padding:5px 14px;font-size:16px;">打招呼</button>
                        </span>
                        </p>
                    </div>
                </div>
            @endfor
        </div>
        <div style="clear:both" ></div>
        {!! $fenye !!}

    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:100%">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">搜索徒友</h4>
                </div>
                <div class="modal-body">
                    <div class="searchbar">
                        <select class="form-control" name="sex" style="">
                            <option value="">性别 - 不限</option>
                            <option value="女">女生</option>
                            <option value="男">男生</option>
                        </select>
                        <select class="form-control" name="mryst" >
                            <option value="">婚况 - 不限</option>
                            <option value="未婚">未婚</option>
                            <option value="已婚">已婚</option>
                            <option value="离异">离异</option>
                            <option value="丧偶">丧偶</option>
                            <option value="保密">保密</option>
                        </select>
                        <select class="form-control" name="age" >
                            <option value="">年龄 - 不限</option>
                            <option value="1-20"><20岁</option>
                            <option value="21-30">21-30岁</option>
                            <option value="31-40">31-40岁</option>
                            <option value="41-50">41-50岁</option>
                            <option value="51-100">>51岁</option>
                        </select>
                        <select class="form-control" id="pro" onchange="loadC(this)" style="width:49%;display: inline-block;">
                            <option value="">地区 - 省</option>
                        </select>
                        <select class="form-control" id="city" style="width:49%;display: inline-block;">
                            <option value="">地区 - 市</option>
                        </select>
                        {{--<div style="margin-top:20px;text-align:right;padding-right:5%;">--}}
                            {{--<button onclick="search()" class="searchb"  >搜 索</button>--}}
                            {{--<button onclick="location.href='/member/list'" class="searchb" style="background: darkseagreen"  >清空条件</button>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button onclick="search()" type="button" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </div>
    </div>
    @include("wap.footer")

@stop
@section("htmlend")
    <script src="/web/js/addr.js" ></script>
    <script>
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
        $(document).ready(function(){
            loadP();
            if( GetQueryString('sex') ) {
                $("select[name=sex]").val(GetQueryString('sex'));
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
        })
        //        sosuo
        function search() {

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
            location.href="/member/list?sex="+sex+"&mryst="+mryst+"&age="+age+"&addr="+addr;
        }

        function GetQueryString(name)
        {
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r!=null)
                return decodeURI(r[2]);
            return null;
        }
    </script>
@stop
