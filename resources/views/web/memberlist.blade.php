@extends("web.common")
@section("title","徒友列表")
@section("css")
    <style>
        select{
            letter-spacing:2px;
        }
        .userlist{
            width:100%;height:100px;margin-top:-20px;
        }
        .useritem{
            height:180px;width:180px;position: relative;background-position:center;background-size:cover;background-repeat:no-repeat;float:left;margin-right:20px;border-radius:5px;margin-top:40px;cursor: pointer;
        }
        .useritem:hover{
            opacity:0.8;
        }
        .useritem div{
            position:absolute;bottom:-30px;height:30px;line-height:30px;color:#444;
            font-size:14px;letter-spacing: 2px;
        }
    </style>
@stop

@section("body")
    @include("web.header")
    <div class="content">
        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>
            <a style="color: #999;" href="/member/dongtai" >会员列表</a>
        </div>
        <div class="searchbar">
            <select class="form-control" style="width:150px;display: inline-block;">
                <option>性别 - 不限</option>
                <option>女生</option>
                <option>男生</option>
            </select>
            <select class="form-control" style="width:150px;display: inline-block;">
                <option>婚况 - 不限</option>
                <option>未婚</option>
                <option>已婚</option>
                <option>离异</option>
            </select>
            <select class="form-control" style="width:150px;display: inline-block;">
                <option>年龄 - 不限</option>
                <option><20岁</option>
                <option>21-30岁</option>
                <option>31-40岁</option>
                <option>41-50岁</option>
                <option>>51岁</option>
            </select>
            <select class="form-control" id="pro" onchange="loadC(this)" style="width:150px;display: inline-block;">
                <option value="">地区 - 省</option>
            </select>
            <select class="form-control" id="city" style="width:150px;display: inline-block;">
                <option value="">地区 - 市</option>
            </select>
        </div>
        <div style="clear:both" ></div>
        <div class="userlist">
            @for( $i=0;$i<count($list);$i++ )
            <div class="useritem" style="background-image:url(/head/{{$list[$i]->userid}});">
                <div>
                    @if( trim($list[$i]->uname) == '' )
                        Ta很懒,竟未填写
                    @else
                        {{$list[$i]->uname}}
                    @endif
                    @if( $list[$i]->sex == '男' )
                        <img src="/web/images/male.png" style="height:18px;margin-left:5px;">
                    @else
                        <img src="/web/images/female.png" style="height:18px;margin-left:5px;">
                    @endif
                </div>
            </div>
            @endfor
        </div>
        <div style="clear:both" ></div>

    </div>
    @include("web.footer")

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
            var val = $(that).val();
            if( $.trim(val) == '' ) {
                $("#city").append("<option value=''>地区 - 市</option>"); return;
            }
            var tmps = city[val];
            for( var i=0;i<tmps.length;i++ ) {
                var node = "<option value='"+tmps[i]+"'>"+tmps[i]+"</option>";
                $("#city").append(node);
            }
        }
        $(document).ready(function(){
            loadP();
        })
    </script>
@stop
