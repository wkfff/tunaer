@extends("web.common")

@section("title","用户主页")

@section("css")
<link rel="stylesheet" href="/web/css/user.css">
@stop

@section("body")
    @include("web.header")
    <style>
        .usernav{
            height:100px;background-color:rgba(255,255,255,0.8);margin-top:30px;
        }
        .usernav span:hover{
            background-color:rgba(255,255,255,1);
        }
        .usernav span{
            display: block;width:120px;height:50px;line-height:50px;
            font-size:18px;float:left;background: rgba(255,255,255,0.7);
            margin-left:15px;margin-top:50px;color:#555;
            text-align: center;border-top-left-radius: 5px;border-top-right-radius:5px;
            cursor: pointer;
        }
        .ubox{
            height:300px;width:100%;background:white;
        }
    </style>
    <div class="bgpic" style="width:100%;height:372px;
         background-image: url(/web/images/s_ban.jpg);background-size:cover;background-position:center;"></div>
    <div class="content" style="position:relative">
        <div class="wrap" style="position: absolute;top:-270px;width:100%;color:#fff;">
            <h2 style="color: #f4a219;">张三的大飞翔
                <img src="/web/images/female.png" style="height:30px;"></h2>
            <div style="width:150px;height:150px;background-image: url(/web/images/p3.jpg);
                background-size:cover;background-position:center;position:absolute;right:0px;top:0px;">
            </div>
            <div class="uinfo" style="float:left;font-size:16px;margin-left:20px;line-height:24px;margin-top:20px;height:24px;">
                年龄：<span style="color:#fff" >28岁</span>
                婚况：<span style="color:#fff" >未婚</span>
                常住：<span style="color:#fff" >四川成都</span>
            </div>
            <div style="position:absolute;right:200px;top:0px;font-size:16px;cursor:pointer;">
                <span>编辑资料</span>
                <img src="/web/images/edit.png" style="height:20px;">
            </div>

            <div style="clear:both" ></div>
            <div class="intro" style="margin-top:10px;margin-left:20px;font-size:16px;line-height:24px;height:24px;max-width:1000px;">
                我不知道是不是真的有这么巧，只能说有太多的话都说不清楚。
            </div>

            <div class="usernav">
                <span>最新动态</span>
                <span>我的游记</span>
                <span>我的活动</span>
                <span>互动留言</span>
                <span>我的相册</span>
                <span>我的好友</span>
                <span>商城订单</span>
            </div>
        </div>
        <div style="clear:both" ></div>
        <div class="ubox">
            cascsdcs
        </div>
    </div>


    @include("web.footer")
@stop