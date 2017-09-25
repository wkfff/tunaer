@extends("wap.common")
@section("title","徒步游记")
@section("css")

    <style>
        .toppic{
            width:100%;height:200px;background-size:cover;margin:0 auto;
            background-position:center;
            background-image: url(/web/images/s_ban.jpg);
            background-repeat:no-repeat;
            /*display: inline-block;*/
            position: relative;
        }
        .usernav{
            height:40px;background-color:#DDD;
        }
        .usernav span:hover{
            background-color:rgba(255,255,255,1);
        }
        .usernav span{
            display: block;width:16.66%;height:40px;line-height:40px;
            font-size:14px;float:left;background: rgba(255,255,255,0.7);
            color:#555;
            text-align: center;
            cursor: pointer;
        }
    </style>
@stop

@section("body")

    <div onclick="history.back()" style="width:40px;height:30px;background:rgba(0,0,0,0.3);color:#fff;position:fixed;left:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
        <span class="glyphicon glyphicon-menu-left" ></span>
    </div>

    <div class="content" >

        <div class="toppic">
            <div onclick="history.back()" style="width:40px;height:30px;color:#fff;position:absolute;right:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
                <span data-toggle="modal" data-target="#myModal2" style="position: absolute;right:10px;top:0px;line-height:45px;" class="glyphicon glyphicon-option-horizontal" ></span>
            </div>
            <div style="width:100px;height:100px;background-image: url(/head/{{$userinfo->userid}});border-radius:50px;
                    background-size:cover;background-position:center;position:absolute;left:50%;top:50%;margin-top:-70px;margin-left:-50px;overflow: hidden">
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->userid )
                    <a href="javascript:void(0)" onclick="$('.userheadinput').trigger('click');"
                       style="position:absolute;display: block;left:0px;bottom:0px;height:30px;text-align: center;line-height: 30px;width:100%;background:rgba(0,0,0,0.5);color:#fff;font-size:0.8em">修改头像</a>
                    <input type="file" class="userheadinput" onchange="updatehead(this)" style="display: none;">
                @endif
            </div>
            <div style="color: #f4a219;position:absolute;left:0px;bottom:34px;width:100%;text-align:center;color:#fff;font-size:16px;">{{ isset($userinfo->uname)?$userinfo->uname : "资料待完善" }}
                @if( $userinfo->sex == '女' )
                    <script> window.sex = "女"; </script>
                    <img src="/web/images/female.png" style="height:15px;">
                @else
                    <script> window.sex = "男"; </script>
                    <img src="/web/images/male.png" style="height:15px;">
                @endif
            </div>

            <div class="uinfo" style="position:absolute;left:0px;bottom:0px;font-size:14px;line-height:34px;height:34px;width:100%;text-align:center;color:#fff;">
                <span style="color:#fff;margin-left:5px;" >{{ isset($userinfo->age)?$userinfo->age : "保密" }}岁</span>
                <span style="color:#fff;margin-left:5px;" >{{ isset($userinfo->mryst)?$userinfo->mryst : "保密" }}</span>
                <span style="color:#fff;margin-left:5px;" >{{ isset($userinfo->addr)?$userinfo->addr : "保密" }}</span>
            </div>
        </div>
        <div class="usernav">
            <span onclick="changetab('dongtai')" >动态</span>
            <span onclick="changetab('youji')">游记</span>
            <span onclick="changetab('huodong')">活动</span>
            <span onclick="changetab('liuyan')">留言</span>
            <span onclick="changetab('photos')">相册</span>
            {{--<span onclick="changetab('friends')">好友</span>--}}
            <span onclick="changetab('shoporder')">订单</span>
        </div>
    </div>

    @include("wap.footer")

@stop

@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>

    </script>

@stop