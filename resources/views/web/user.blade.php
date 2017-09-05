@extends("web.common")

@section("title","用户主页")
@section("css")
    <link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">
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
            width:100%;background:white;min-height:500px;
        }
        .imgdiv{
            height:150px;width:150px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
        .tab{
            display: none;
        }
        #myEditor{
            height:50vh !important;
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
            <div style="width:150px;height:150px;background-image: url(/head/{{$userinfo->uid}});
                background-size:cover;background-position:center;position:absolute;right:0px;top:0px;">
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->uid )
                    <a href="javascript:void(0)" onclick="$('.userheadinput').trigger('click');"
                       style="position:absolute;display: block;left:0px;bottom:0px;height:30px;text-align: center;line-height: 30px;width:100%;background:rgba(0,0,0,0.5);color:#fff;">修改头像</a>
                    <input type="file" class="userheadinput" onchange="updatehead(this)" style="display: none;">
                @endif

            </div>
            <div class="uinfo" style="float:left;font-size:16px;margin-left:20px;line-height:24px;margin-top:20px;height:24px;">
                年龄：<span style="color:#fff" >{{ isset($userinfo->age)?$userinfo->age : "保密" }}岁</span>
                婚况：<span style="color:#fff" >{{ isset($userinfo->mryst)?$userinfo->mryst : "保密" }}</span>
                常住：<span style="color:#fff" >{{ isset($userinfo->addr)?$userinfo->addr : "保密" }}</span>
            </div>
            @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->uid )
            <div style="position:absolute;right:200px;top:0px;font-size:16px;cursor:pointer;" data-toggle="modal" data-target="#myModal">
                <span>编辑资料</span>
                <img src="/web/images/edit.png" style="height:20px;">
            </div>
            @endif

            <div style="clear:both" ></div>
            <div class="intro" style="margin-top:10px;margin-left:20px;font-size:16px;line-height:24px;height:24px;max-width:1000px;">
                {{ isset($userinfo->intro)?$userinfo->intro : "Ｔａ暂时没有填写个人介绍" }}
            </div>

            <div class="usernav">
                <span onclick="changetab('dongtai')" >最新动态</span>
                <span onclick="changetab('youji')">我的游记</span>
                <span onclick="changetab('huodong')">我的活动</span>
                <span onclick="changetab('liuyan')">互动留言</span>
                <span onclick="changetab('photos')">我的相册</span>
                <span onclick="changetab('friends')">我的好友</span>
                <span onclick="changetab('shoporder')">商城订单</span>
            </div>
        </div>
        <div style="clear:both;height:30px;" ></div>
        <div class="ubox">
            <input type="file" class="uploadinput" onchange="uploadImg(this)" style="display: none;" >
            <input type="file" class="uploadinput2" onchange="uploadImg2(this)" style="display: none;" >
            <div class="tab youji">
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->uid )
                    <input type="text" class="form-control" placeholder="游记标题" style="width:900px;margin-bottom:10px" >
                    <script type="text/plain" id="myEditor" style="width:900px;"></script>
                    <button onclick="$('.uploadinput2').trigger('click')" style="outline:none;margin-top:10px;" type="button" class="btn btn-default">添加封面</button>
                    <button type="button" onclick="fabuyouji()" class="btn btn-success" style="margin-top:10px;">确认发布</button>
                @endif
                <div class="youjipics"></div>
                <div style="clear:both;height:20px;" ></div>
                <div class="youjilist">

                </div>
            </div>
            <div class="tab dongtai" >
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->uid )
                <div>
                    <textarea class="form-control"  rows="5" placeholder="发点动态..."></textarea>
                    <div class="dongtaipics" ></div>
                    <div style="clear:both;height:20px;" ></div>
                    <button style="outline:none" onclick="$('.uploadinput').trigger('click')" class="btn btn-default">添加图片</button>
                    <button style="outline:none" class="btn btn-success " onclick="fadongtai(this)" style="margin-left:30px;">立即发布</button>
                </div>
                @endif
                <div style="clear:both;height:20px;" ></div>
                @for( $i=0;$i<count($dongtai);$i++ )
                    <div>
                        <div>{{$dongtai[$i]->content}}</div>
                        <?php $pics=explode("#",$dongtai[$i]->imgs); ?>
                        @for( $j=0;$j<count($pics);$j++ )
                            <div class="imgdiv" onclick="img2big(this)" style="background-image:url(/web/data/images/{{$pics[$j]}})" ></div>
                        @endfor
                        <div style="clear:both;height:20px;" ></div>
                        <div style="margin-bottom:20px">
                            <a href="/user/{{$dongtai[$i]->uid}}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/{{$dongtai[$i]->uid}});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle" ></div></a>
                            <span>发布于 {{$dongtai[$i]->ftime}}</span>
                            <button onclick="dongtaicmtmp({{$dongtai[$i]->id}},'dianzan')" style="outline:none;margin-left:10px;" type="button" class="btn btn-default btn-sm">
                                <img src="/web/images/xihuan.png" style="height:18px;"><span style="margin-left:10px;" >点赞{{$dongtai[$i]->zancnt}}</span>
                            </button>
                            <button onclick="dongtaicmtmp({{$dongtai[$i]->id}},'liuyan')" style="outline:none;" type="button" class="btn btn-default btn-sm">
                                <img src="/web/images/liuyan.png" style="height:15px;"><span style="margin-left:10px;" >评论{{$dongtai[$i]->cmcnt}}</span>
                            </button>
                            <button onclick="zhankai({{$dongtai[$i]->id}},this)" style="outline:none;" type="button" class="btn btn-default btn-sm">
                                <img src="/web/images/zhankai.png" style="width:10px;"><span style="margin-left:10px;" >展开评论</span>
                            </button>
                            <div style="height:100px;width:100%;border:1px solid #eee;margin-top:10px;display: none;" >

                            </div>
                        </div>
                    </div>
                @endfor
                <div style="clear:both;height:20px;" ></div>
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

    <!-- Modal -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">评论</h4>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" name="comment" rows="3" placeholder="评论内容"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button onclick="dongtaipinglun()" type="button" class="btn btn-primary">提交评论</button>
                </div>
            </div>
        </div>
    </div>

@stop


@section("htmlend")
    <script src="/admin/umediter/umeditor.config.js" ></script>
    <script src="/admin/umediter/umeditor.min.js" ></script>
    <script src="/web/js/user.js"></script>
    <script>
        $(document).ready(function(){
            window.um = UM.getEditor('myEditor');
            window.uid = "{{$userinfo->uid}}";
            var tab = location.href.split("#");
            if( tab.length == 2 ) {
                $("."+tab[1]).css("display","block");
            }else{
                changetab("dongtai");
            }
        })
    </script>
@stop