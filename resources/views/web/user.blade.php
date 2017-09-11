@extends("web.common")

@section("title","用户主页")
@section("css")
    <link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">
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
            width:100%;background:white;min-height:500px;
        }
        .imgdiv{
            height:150px;width:150px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
        .imgdiv2{
            height:200px;width:270px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:30px;
        }
        .tab{
            display: none;
        }
        #myEditor{
            height:50vh !important;
        }
        .searchb{
            letter-spacing: 4px;background:#F03B6E;color:#fff;
            border-radius:5px;cursor:pointer;
            font-weight:bold;margin-left:50px;
            font-size:16px;height:40px;width:120px;
            display: inline-block;line-height:40px;text-align:center;
        }
        .searchb:hover{
            box-shadow: 1px 1px 10px rgba(255,255,255,0.9);
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
                <div onclick="openchatbox({{$userinfo->userid}})" class="searchb"  >发消息</div>
                <div onclick="zhaohu({{$userinfo->userid}})" style="margin-left:10px;background:dodgerblue" class="searchb"  >打招呼</div>
            </h2>

            <div style="width:150px;height:150px;background-image: url(/head/{{$userinfo->userid}});
                background-size:cover;background-position:center;position:absolute;right:0px;top:0px;">
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->userid )
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
            @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->userid )
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
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->userid )
                    <button type="button" onclick="$('.createyoujipanel').toggle()" class="btn btn-default" style="width:120px;height:40px;margin-left:10px;">添加游记 +</button>
                    <div class="createyoujipanel" style="display: none;margin-top:10px;margin-left:10px;">
                        <input type="text" class="form-control" placeholder="游记标题" style="width:900px;margin-bottom:10px" >
                        <script type="text/plain" id="myEditor" style="width:900px;"></script>
                        <button onclick="$('.uploadinput2').trigger('click')" style="outline:none;margin-top:10px;" type="button" class="btn btn-default">添加封面</button>
                        <button type="button" onclick="fabuyouji()" class="btn btn-success" style="margin-top:10px;">确认发布</button>
                        <div class="youjipics"></div>
                    </div>
                @endif

                <div class="youjibox"></div>
                <div style="clear:both;height:20px;" ></div>
                <div onclick="getyoujis({{$userinfo->userid}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
            </div>
            <div class="tab photos">
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->userid )
                    <input type="file" class="uploadphoto" onchange="uploadphoto(this)" style="display:none" >
                    <button type="button" onclick="$('.uploadphoto').trigger('click')" class="btn btn-default" style="width:120px;height:40px;">添加照片</button>
                @endif
                <div class="photosbox">

                </div>
                <div style="clear:both;height:20px;" ></div>
                <div onclick="getphotos({{$userinfo->userid}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
            </div>
            <div class="tab liuyan">
                <div>
                    <textarea class="form-control"  rows="5" placeholder="留言内容..."></textarea>
                    <div style="clear:both;height:20px;" ></div>
                    <button  class="btn btn-default " onclick="liuyan(this)" style="outline:none;width:120px;height:45px;">给Ta留言</button>
                </div>
                <div class="liuyanbox"></div>
                <div onclick="getliuyans({{$userinfo->userid}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
            </div>
            <div class="tab friends">
                <div class="friendbox">

                </div>
                <div style="clear:both;height:20px;" ></div>
                <div onclick="getchatlist({{$userinfo->userid}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
            </div>
            <div class="tab dongtai" >
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->userid )
                <div>
                    <textarea class="form-control"  rows="5" placeholder="发点动态..."></textarea>
                    <div class="dongtaipics" ></div>
                    <div style="clear:both;height:20px;" ></div>
                    <button style="outline:none" onclick="$('.uploadinput').trigger('click')" class="btn btn-default">添加图片</button>
                    <button style="outline:none" class="btn btn-success " onclick="fadongtai(this)" style="margin-left:30px;">立即发布</button>
                </div>
                @endif
                <div style="clear:both;height:20px;" ></div>
                <div class="dongtaibox">

                </div>
                <div style="clear:both;height:20px;" ></div>
                    <div onclick="getdongtais({{$userinfo->userid}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
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
                            <input type="radio" value="未婚" checked name="mryst" >未婚
                        </label>
                        <label >
                            <input type="radio" value="已婚" name="mryst">已婚
                        </label>
                        <label>
                            <input type="radio" value="离异"  name="mryst" >离异
                        </label>
                        <label >
                            <input type="radio" value="丧偶" name="mryst">丧偶
                        </label>
                        <label >
                            <input type="radio" value="保密" name="mryst">保密
                        </label>
                    </div>
                    <div class="form-group">
                        <label >常住地</label><br>
                        <select class="form-control" id="pro"  onchange="loadC(this)" style="width:150px;display: inline-block;">
                            <option value="">地区 - 省</option>
                        </select>
                        <select class="form-control" id="city" style="width:150px;display: inline-block;">
                            <option value="">地区 - 市</option>
                        </select>
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

    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:600px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">与 <span style="color:cornflowerblue">{{$userinfo->uname}}</span> 聊天</h4>
                </div>
                <div class="modal-body">
                    <div style="height:50vh; max-height:500px;min-height:400px;width:100%;overflow-y: auto;" >
                        <div onclick="getchathistory({{$userinfo->userid}})" style="color:dodgerblue;height:30px;width:100%;text-align:center;cursor: pointer;" >加载更多</div>
                        <div class="chatbox">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="chatcontent" type="text" class="form-control" placeholder="请输入内容..." style="width:500px;height:34px;float:left" >
                    <button onclick="sendchat({{$userinfo->userid}})" class="btn btn-primary" type="button" style="float:right;margin-left:10px;">发送</button>
                </div>
            </div>
        </div>
    </div>

@stop


@section("htmlend")
    <script src="/admin/umediter/umeditor.config.js" ></script>
    <script src="/admin/umediter/umeditor.min.js" ></script>
    <script src="/web/js/user.js"></script>
    <script src="/web/js/addr.js" ></script>
    <script>
        $(document).ready(function(){
            loadP();
            getchatlist({{$userinfo->userid}});
            getphotos({{$userinfo->userid}});
            getdongtais({{$userinfo->userid}});
            getliuyans({{$userinfo->userid}});
            getyoujis({{$userinfo->userid}});

            window.um = UM.getEditor('myEditor');
            window.uid = "{{$userinfo->userid}}";
            window.diqu = "{{$userinfo->addr}}";
            var tab = location.href.split("#");
            if( tab.length == 2 ) {
                $("."+tab[1]).css("display","block");
            }else{
                changetab("dongtai");
            }

            if( "女" == window.sex) {
                $($("input[name=sex]")[1]).prop("checked","true");
            }else{
                $($("input[name=sex]")[0]).prop("checked","true");
            }
            var mrysts = $("input[name=mryst]");
            for( var i=0;i<mrysts.length;i++ ) {
                if( mrysts[i].value == $($(".uinfo span")[1]).text() ) {
                    $(mrysts[i]).prop("checked","true");
                }
            }
            setTimeout(function(){
                var pr = window.diqu.split("-")[0];
                var ci = window.diqu.split("-")[1];
                if( pr != '' ) {
                    $("#pro").val(pr);
                    $("#pro").trigger("change");
                }if( ci != '' ) {
                    $("#city").val(ci);
                }

            })
        })

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
    </script>
@stop