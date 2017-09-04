@extends("web.common")

@section("title","用户主页")

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
        .imgdiv{
            height:150px;width:150px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;
        }
    </style>
    <div class="bgpic" style="width:100%;height:372px;
         background-image: url(/web/images/s_ban.jpg);background-size:cover;background-position:center;"></div>
    <div class="content" style="position:relative">
        <div class="wrap" style="position: absolute;top:-270px;width:100%;color:#fff;">
            <h2 style="color: #f4a219;">{{ isset($userinfo->uname)?$userinfo->uname : "资料待完善" }}
                @if( $userinfo->sex == '女' )
                    <script> window.sex = "女"; </script>
                    <img src="/web/images/female.png" style="height:30px;">
                @else
                    <script> window.sex = "男"; </script>
                    <img src="/web/images/male.png" style="height:30px;">
                @endif
            </h2>
            <div style="width:150px;height:150px;background-image: url(/head/{{Session::get('uid')}});
                background-size:cover;background-position:center;position:absolute;right:0px;top:0px;">
                <a href="javascript:void(0)" onclick="$('.userheadinput').trigger('click');" style="position:absolute;display: block;left:0px;bottom:0px;height:30px;text-align: center;line-height: 30px;width:100%;background:rgba(0,0,0,0.5);color:#fff;">修改头像</a>
                <input type="file" class="userheadinput" onchange="updatehead(this)" style="display: none;">
            </div>
            <div class="uinfo" style="float:left;font-size:16px;margin-left:20px;line-height:24px;margin-top:20px;height:24px;">
                年龄：<span style="color:#fff" >{{ isset($userinfo->age)?$userinfo->age : "保密" }}岁</span>
                婚况：<span style="color:#fff" >{{ isset($userinfo->mryst)?$userinfo->mryst : "保密" }}</span>
                常住：<span style="color:#fff" >{{ isset($userinfo->addr)?$userinfo->addr : "保密" }}</span>
            </div>
            <div style="position:absolute;right:200px;top:0px;font-size:16px;cursor:pointer;" data-toggle="modal" data-target="#myModal">
                <span>编辑资料</span>
                <img src="/web/images/edit.png" style="height:20px;">
            </div>

            <div style="clear:both" ></div>
            <div class="intro" style="margin-top:10px;margin-left:20px;font-size:16px;line-height:24px;height:24px;max-width:1000px;">
                {{ isset($userinfo->intro)?$userinfo->intro : "Ｔａ暂时没有填写个人介绍" }}
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
        <div style="clear:both;height:30px;" ></div>
        <div class="ubox">
            <div class="dongtai">
                {{--dongtai list--}}
                <div>
                    <textarea class="form-control"  rows="3" placeholder="发点动态..."></textarea>
                    <br>
                    <div class="dongtaipics" >

                        <div class="imgdiv" onclick="img2big(this)" style="background-image:url(/web/images/p1.jpg)" ></div>
                        <div class="imgdiv" onclick="img2big(this)" style="background-image:url(/web/images/p2.jpg)" ></div>
                        <div class="imgdiv" onclick="img2big(this)" style="background-image:url(/web/images/p3.jpg)" ></div>
                        <div class="imgdiv" onclick="img2big(this)" style="background-image:url(/web/images/p4.jpg)" ></div>
                        <div class="imgdiv" onclick="img2big(this)" style="background-image:url(/web/images/p5.jpg)" ></div>
                        <div class="imgdiv" onclick="img2big(this)" style="background-image:url(/web/images/p6.jpg)" ></div>
                    </div>
                    <div style="clear:both;height:20px;" ></div>
                    <button class="btn btn-default">添加图片</button>
                    <button class="btn btn-success " style="margin-left:30px;">立即发布</button>
                </div>
            </div>

        </div>
    </div>


    @include("web.footer")

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改资料</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label >昵称</label>
                        <input type="text" value="{{$userinfo->uname}}" name="uname" placeholder="张三" class="form-control">
                    </div>
                    <div class="form-group">
                        <label >年龄</label>
                        <input type="text" class="form-control" placeholder="27" name="age" value="{{$userinfo->age}}">
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" value="男" name="sex">男生
                        </label>
                        <label >
                            <input type="radio" value="女" name="sex">女生
                        </label>
                        <span style="margin:0 20px;">|</span>
                        <label>
                            <input type="radio" value="未婚" name="mryst" >未婚
                        </label>
                        <label>
                            <input type="radio" value="离异"  name="mryst" >离异
                        </label>
                        <label >
                            <input type="radio" value="已婚" name="mryst">已婚
                        </label>
                    </div>
                    <div class="form-group">
                        <label >常住地</label>
                        <input type="text" class="form-control" name="addr" value="{{$userinfo->addr}}" placeholder="沈阳" >
                    </div>
                    <label >自我介绍</label>
                    <textarea class="form-control" name="intro" rows="3" placeholder="自我介绍">{{$userinfo->intro}}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" onclick="save()" class="btn btn-primary">保存设置</button>
                </div>
            </div>
        </div>
    </div>

@stop
<script src="/web/js/jquery.min.js" ></script>
<script src="/web/js/common.js" ></script>
<script src="/web/js/user.js">
</script>