@extends("wap.common")
@section("title","注册新用户")
@section("css")

@stop

@section("body")
    <h3>注册新账号</h3>
    <div onclick="openreg()" style="height:50px;width:100%;background:#ff9046;color:#fff;text-align:center;line-height:50px;font-size:16px;position: fixed;bottom:0px;left:0px;" >立即注册</div>

@stop

@section("htmlend")

    <script>
        $(document).ready(function(){
            openreg();
        })
    </script>
@stop