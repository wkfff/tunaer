@extends("wap.common")
@section("title","徒步游记")
@section("css")
    <link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">
    <link rel="stylesheet" href="/wap/css/user.css">
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
        @if( !empty(Session::get('uid')) && Session::get('uid') == $userinfo->userid )
            .usernav span{
                display: block;width:20%;height:40px;line-height:40px;
                font-size:14px;float:left;background: rgba(255,255,255,0.7); color:#555;
                text-align: center; cursor: pointer;
            }
        @else
            .usernav span{
                display: block;width:25%;height:40px;line-height:40px;
                font-size:14px;float:left;background: rgba(255,255,255,0.7); color:#555;
                text-align: center; cursor: pointer;
            }
        @endif

        .ubox{
            width:100%;background:white;min-height:500px;padding:10px;
        }
        .tab{
            display: none;
        }
        .imgdiv{
            height:100px;width:100px;background-size:cover;float:left;margin-right:10px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
        .imgdiv2{
            height:100px;width:100px;background-size:cover;float:left;margin-right:10px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
    </style>
@stop

@section("body")

    <div onclick="history.back()" style="width:40px;height:30px;background:rgba(0,0,0,0.3);color:#fff;position:fixed;left:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
        <span class="glyphicon glyphicon-menu-left" ></span>
    </div>
    @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->userid )
        <div style="width:40px;height:30px;color:#fff;position:absolute;right:10px;top:10px;z-index:999;text-align:center;line-height:30px;">
            <span data-toggle="modal" data-target="#myModal" style="font-size:18px;position: absolute;right:10px;top:0px;line-height:45px;" class="glyphicon glyphicon-edit" ></span>
        </div>
    @endif


    <div class="content" >

        <div class="toppic">
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

            @if( !empty(Session::get('uid')) && Session::get('uid') == $userinfo->userid )
                <span onclick="changetab('huodong')">活动</span>
            @endif
            <span onclick="changetab('liuyan')">留言</span>
            <span onclick="changetab('photos')">相册</span>
            {{--<span onclick="changetab('friends')">好友</span>--}}
            {{--<span onclick="changetab('shoporder')">订单</span>--}}
        </div>

        <div class="ubox"  >
            <input type="file" class="uploadinput" onchange="uploadImg(this)" style="display: none;" >
            <input type="file" class="uploadinput2" onchange="uploadImg2(this)" style="display: none;" >
            <div class="tab youji">
                @if( !empty(Session::get("uid")) && Session::get("uid") == $userinfo->userid )
                    <button type="button" onclick="$('.createyoujipanel').toggle()" class="btn btn-default" style="width:120px;height:40px;margin-bottom:10px;">添加游记 +</button>
                    <div class="createyoujipanel" style="display: none;margin-top:10px;">
                        <input type="text" class="form-control" placeholder="游记标题" style="width:100%;margin-bottom:10px" >
                        <script type="text/plain" id="myEditor" style="width:300px;height:200px;"></script>
                        <button onclick="$('.uploadinput2').trigger('click')" style="outline:none;margin-top:10px;margin-bottom:10px;" type="button" class="btn btn-default">添加封面</button>
                        <button type="button" onclick="fabuyouji()" class="btn btn-success" style="margin-top:10px;margin-bottom:10px;">确认发布</button>
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
                @if( empty(Session::get("uid")) || Session::get("uid") != $userinfo->userid )
                <div>
                    <textarea class="form-control"  rows="5" placeholder="留言内容..."></textarea>
                    <div style="clear:both;height:20px;" ></div>
                    <button  class="btn btn-default " onclick="liuyan(this)" style="outline:none;width:120px;height:45px;">给Ta留言</button>
                </div>
                @endif
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
            <div class="tab shoporder">
                <div class="shoporderbox">

                </div>
                <div style="clear:both;height:20px;" ></div>
                <div onclick="getshoporder({{$userinfo->userid}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
            </div>
            <div class="tab huodong">
                <div class="tubuorderbox">

                </div>
                <div style="clear:both;height:20px;" ></div>
                <div onclick="gettubuorder({{$userinfo->userid}})" style="text-align:center;width:100%;color:dodgerblue;cursor:pointer;">加载更多</div>
            </div>

        </div>

    </div>


    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:100%">
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:100%">
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
                        <br>
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

    <div class="modal fade" id="paybox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <style>
                    .payimg p{
                        border: 1px solid #999;padding:10px;cursor: pointer;
                    }
                    .payimg p:hover{
                        border: 1px solid dodgerblue;
                        opacity:0.6;
                    }
                </style>
                <div class="modal-body" style="padding:40px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 style="margin-bottom:40px;">
                        请选择支付方式:
                    </h3>
                    <div class="payimg" style="width:100%;overflow-y: auto;" >
                        <p onclick="createpay('alipay_wap')">支付宝<img style="cursor:pointer;vertical-align: middle;margin-left:40px;height:50px;" src="/web/images/alipay.jpg" ></p>
                        <a id="wechatlink" href="#" target="_blank" onclick="$('#payfooter').css('display','block');"><p >微信支付<img style="cursor:pointer;vertical-align: middle;margin-left:15px;height:50px;" src="/web/images/wxpay.png" ></p></a>
                        <br>
                        <div id="qrcode"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="payfooter" style="height:100%;width:100%;position:fixed;z-index:99999;left:0px;top:0px;display:none" >
        <div style="position: absolute;bottom:0px;left:0px;width:100%;height:200px;background:#ddd;text-align:center;" >
            <button onclick="location.reload()" style="border:1px solid #fff;color:#fff;height:80px;width:80%;background: #e83888;font-size:1.5em;margin:10px 0;">支付成功</button>
            <button onclick="location.reload()" style="border:1px solid #fff;color:#000;height:80px;width:80%;background: darkgrey;font-size:1.5em">返回</button>
        </div>
    </div>

    @include("wap.footer")

@stop

@section("htmlend")
    <script src="/admin/umediter/umeditor.config.js" ></script>
    <script src="/admin/umediter/umeditor.min.js" ></script>
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script src="/wap/js/user.js" ></script>
    <script src="/web/js/addr.js" ></script>
    <script>
        $(document).ready(function(){
            loadP();
            getchatlist({{$userinfo->userid}});
            getphotos({{$userinfo->userid}});
            getdongtais({{$userinfo->userid}});
            getliuyans({{$userinfo->userid}});
            getyoujis({{$userinfo->userid}});
            @if( !empty(Session::get('uid')) && Session::get('uid') == $userinfo->userid )
                {{--getshoporder({{$userinfo->userid}});--}}
                gettubuorder({{$userinfo->userid}});
            @endif

//            window.um = UM.getEditor('myEditor');
            window.uid = "{{$userinfo->userid}}";
            window.diqu = "{{$userinfo->addr}}";
            window.um = UM.getEditor('myEditor', {
                /* 传入配置参数,可配参数列表看umeditor.config.js */
                toolbar: ['justifycenter justifyright justifyleft fullscreen backcolor forecolor underline inserttitle simpleupload link emotion map | bold italic underline'],
                initialFrameWidth:$(window).width()-20
            });
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