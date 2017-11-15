@extends('admin.common')
<link rel="stylesheet" href="/web/kindeditor/themes/default/default.css">
@section("title","发布徒步活动")

@section("content")

    <div class="form-group">
        <label for="exampleInputEmail1">图文介绍 <span style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold;outline: none;" data-toggle="modal"  data-target="#myModal">活动属性</a></span><span style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold;outline: none;" onclick="$('.tubupics').slideDown()">活动图片</a></span></label>
<p style="text-align: right;color:blue;width:800px;">
    提示:徒步内容编辑中请使用 shift+回车代替回车
</p>
    </div>
    <link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">

    <textarea id="editor_id" name="content" style="width:800px;min-height:600px; ">

        <div id="jhxx"  style="margin:0px;padding:0px;border-width:1px 1px 3px;border-style:solid;border-color:#DCDCDC #DCDCDC #FF8800;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;height:40px;line-height:40px;background:#F6F5F5;position:relative;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <h2 class="detailh2" style="margin:0px 0px 0px 20px;font-size:14px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;float:left;display:inline;color:#4F4F4F;">
                <img style="height:20px;vertical-align: middle;" src="/web/tubiao/1.png"><span class="icon-bright" style="margin:0px 10px 0px 0px;padding:0px;border:0px;vertical-align:middle;-webkit-tap-highlight-color:transparent;background-image:url(&quot;background-repeat:no-repeat;display:inline-block;width:16px;height:16px;background-position:-217px -80px;">&nbsp;</span><span>集合信息</span>
            </h2>
        </div>
        <div style="margin:0px 0px 15px;padding:0px 0px 6px;border-width:0px 1px 1px;border-style:solid;border-color:#DCDCDC;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;background:#F6F5F5;font-size:14px;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <div style="margin:0px;padding:10px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;">
                <p>&nbsp;</p>
            </div>
        </div>

        <div id="ckxc"  style="margin:0px;padding:0px;border-width:1px 1px 3px;border-style:solid;border-color:#DCDCDC #DCDCDC #FF8800;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;height:40px;line-height:40px;background:#F6F5F5;position:relative;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <h2 class="detailh2"  style="margin:0px 0px 0px 20px;font-size:14px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;float:left;display:inline;color:#4F4F4F;">
                <img style="height:20px;vertical-align: middle;" src="/web/tubiao/2.png"><span class="icon-bright" style="margin:0px 10px 0px 0px;padding:0px;border:0px;vertical-align:middle;-webkit-tap-highlight-color:transparent;background-image:url(&quot;background-repeat:no-repeat;display:inline-block;width:16px;height:16px;background-position:-217px -80px;">&nbsp;</span><span>参考行程</span>
            </h2>
        </div>
        <div  style="margin:0px 0px 15px;padding:0px 0px 6px;border-width:0px 1px 1px;border-style:solid;border-color:#DCDCDC;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;background:#F6F5F5;font-size:14px;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <div  style="margin:0px;padding:10px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;">
                <p>&nbsp;</p>
            </div>
        </div>

        <div id="hdxq" style="margin:0px;padding:0px;border-width:1px 1px 3px;border-style:solid;border-color:#DCDCDC #DCDCDC #FF8800;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;height:40px;line-height:40px;background:#F6F5F5;position:relative;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <h2 class="detailh2"  style="margin:0px 0px 0px 20px;font-size:14px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;float:left;display:inline;color:#4F4F4F;">
                <img style="height:20px;vertical-align: middle;" src="/web/tubiao/6.png"><span class="icon-bright" style="margin:0px 10px 0px 0px;padding:0px;border:0px;vertical-align:middle;-webkit-tap-highlight-color:transparent;background-image:url(&quot;background-repeat:no-repeat;display:inline-block;width:16px;height:16px;background-position:-217px -80px;">&nbsp;</span><span>活动详情</span>
            </h2>
        </div>
        <div style="margin:0px 0px 15px;padding:0px 0px 6px;border-width:0px 1px 1px;border-style:solid;border-color:#DCDCDC;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;background:#F6F5F5;font-size:14px;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <div style="margin:0px;padding:10px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;">
                <p>&nbsp;</p>
            </div>
        </div>

        <div id="ydxz"  style="margin:0px;padding:0px;border-width:1px 1px 3px;border-style:solid;border-color:#DCDCDC #DCDCDC #FF8800;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;height:40px;line-height:40px;background:#F6F5F5;position:relative;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <h2 class="detailh2"  style="margin:0px 0px 0px 20px;font-size:14px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;float:left;display:inline;color:#4F4F4F;">
                <img style="height:20px;vertical-align: middle;" src="/web/tubiao/5.png"><span class="icon-bright" style="margin:0px 10px 0px 0px;padding:0px;border:0px;vertical-align:middle;-webkit-tap-highlight-color:transparent;background-image:url(&quot;background-repeat:no-repeat;display:inline-block;width:16px;height:16px;background-position:-217px -80px;">&nbsp;</span><span>预订须知</span>
            </h2>
        </div>
        <div  style="margin:0px 0px 15px;padding:0px 0px 6px;border-width:0px 1px 1px;border-style:solid;border-color:#DCDCDC;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;background:#F6F5F5;font-size:14px;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <div style="margin:0px;padding:10px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;">
                <p>&nbsp;</p>
            </div>
        </div>

        <div id="qtxx"  style="margin:0px;padding:0px;border-width:1px 1px 3px;border-style:solid;border-color:#DCDCDC #DCDCDC #FF8800;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;height:40px;line-height:40px;background:#F6F5F5;position:relative;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <h2 class="detailh2"  style="margin:0px 0px 0px 20px;font-size:14px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;float:left;display:inline;color:#4F4F4F;">
                <img style="height:20px;vertical-align: middle;" src="/web/tubiao/3.png"><span class="icon-bright" style="margin:0px 10px 0px 0px;padding:0px;border:0px;vertical-align:middle;-webkit-tap-highlight-color:transparent;background-image:url(&quot;background-repeat:no-repeat;display:inline-block;width:16px;height:16px;background-position:-217px -80px;">&nbsp;</span><span>其他信息</span>
            </h2>
        </div>
        <div style="margin:0px 0px 15px;padding:0px 0px 6px;border-width:0px 1px 1px;border-style:solid;border-color:#DCDCDC;border-image:initial;vertical-align:baseline;-webkit-tap-highlight-color:transparent;font-family:微软雅黑;background:#F6F5F5;font-size:14px;color:#666666;letter-spacing:0.5px;white-space:normal;">
            <div style="margin:0px;padding:10px;border:0px;vertical-align:baseline;-webkit-tap-highlight-color:transparent;">
                <p>&nbsp;</p>
            </div>
        </div>
        <br>
    </textarea>
    {{--<script type="text/plain" id="myEditor" style="width:900px;"></script>--}}
    <button type="button" onclick="fabu()" class="btn btn-primary red" style="margin-top:10px;">确认发布</button>

@stop

<!-- Modal -->
<div class="modal fade" id="myModal" style="display: none;" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">活动属性</h4>
            </div>
            <style>
               #inputcls input{
                    height:30px !important;width:250px !important;border: none !important;border:1px solid #999 !important;
               }
            </style>
            <div class="modal-body">
                <div style="text-align: left;">
                    @for( $i=0;$i<count($types);$i++ )
                        <input type="radio" value="{{$types[$i]->id}}" name="types" >{{$types[$i]->name}}
                    @endfor
                </div>
                <div id="inputcls">
                    <input type="text" value="" placeholder="主题" name="title" style="width: 503px !important;margin-top:10px;" name="title" ><br>
                    <input type="text" value="" placeholder="几天" name="howlong" >
                    <input type="text" value="" placeholder="目的地" name="mudidi" ><br>
                    <input type="text" value="" placeholder="出发时间 格式:2017-12-15" name="startday" >
                    <input type="text" value="" placeholder="返回时间" name="endday" ><br>
                    <input type="text" value="" placeholder="集合地点,多个集合地点使用#号隔开" name="jihedidian" >
                    <input type="text" value="" placeholder="集合时间" name="jihetime" ><br>
                    <input type="text" value="" placeholder="价格" name="price" >
                    <input type="text" value="" placeholder="交通方式" name="jiaotong" ><br>
                    <input type="text" value="" placeholder="景点" name="jingdian" >
                    <input type="text" value="" placeholder="活动内容" name="neirong" ><br>
                    <input type="text" value="" placeholder="距离" name="juli" >
                    <input type="text" value="" placeholder="特色请用#号隔开" name="tese" ><br>
                    <input type="text" value="" placeholder="强度" name="qiangdu" >
                    <input type="text" value="" placeholder="需要多少人" name="need" ><br>
                    <input type="text" value="" placeholder="领队" name="leader" >
                    <input type="text" value="" placeholder="联系电话" name="phone" ><br>
                    <input type="text" style="width:504px !important;" value="" placeholder="报名截止时间 格式:2017-12-15 09:30:00" name="jiezhi" ><br>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" onclick="save()" class="btn btn-primary">保存</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<style>
    .pics div{
        width:280px;height:180px;margin:5px;background-repeat:no-repeat;
        float: left;background-position: center;
        background-size:cover;
    }
</style>
<div class="tubupics" onclick="$(this).slideUp()" style="width:100%;height: 100%;position:fixed;z-index:9999;left:0px;top:0px;display:none" >

        <div onclick="zuzhi(event)" style="width:1000px;height:570px;background:white;position:absolute;top:50%;left:50%;
        margin-left:-500px;margin-top:-285px;box-shadow:1px 3px 15px rgba(0,0,0,0.8);overflow-y: auto;padding:10px;  " >
            <button onclick="$('.uploadfengmian').trigger('click');zuzhi(event);" type="button" class="btn btn-primary" style="position:absolute;top:10px;right:10px;" >添加图片</button>
            <input class="uploadfengmian" type="file" style="display: none;" onchange="uploadImg(this)">
            <button onclick="$('.tubupics').slideUp();" type="button" class="btn btn-primary red" style="position:absolute;top:60px;right:10px;" >立即保存</button>
            <span style="position:absolute;top:110px;right:10px;" >双击图片删除</span>
            <div class="pics" style="width:900px;" >

            </div>
        </div>
</div>

@section("htmlend")

    <script src="/web/kindeditor/kindeditor-all-min.js" ></script>
    <script src="/web/kindeditor/lang/zh-CN.js" ></script>

    <script>
        KindEditor.ready(function(K) {
            window.editor = K.create('textarea[name="content"]', {
                allowImageUpload : true,
                filterMode:false,
                uploadJson : '/web/kindeditor/php/upload_json.php',
                fileManagerJson : '/web/kindeditor/php/file_manager_json.php',
                allowFileManager : true
            });
        });
        function fabu() {
            var t1 = $("#inputcls input");
            for( var i=0;i<t1.length;i++ ) {
                console.log(t1[i].value);
                if( t1[i].value == '' ) {
                    toast("属性不完整"); return ;
                }
            }
            if( checkpictures() ) {
                window.shuxing.tuwen = window.editor.html();

                $.post("/admin/dofabutubu",window.shuxing,function(data){
                    if( ajaxdata(data) ) {
                        toast("发布成功");
                        location.href="/admin/tubulist";
                    }
                })
            }


        }
        function checkpictures() {
            var pics = $(".pics div");
            if( pics.length == 0 ) {
                toast("徒步活动的图片缺少"); return false;
            }
            if(!window.shuxing) {
                toast("徒步活动的属性缺少"); return  false;
            }
            var imgs = [];
            for( var i=0 ; i<pics.length; i++ ) {
                var url = $(pics[i]).css("background-image");
//                console.log(url.split('/').pop());
                var img = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];
                imgs.push(img);
            }
            window.shuxing.pictures = imgs.join("#");
            return true;
        }

        function save() {
            window.shuxing = {
                "types":$("input[name=types]:checked").val(),
                "title":$("input[name=title]").val(),
                "howlong":$("input[name=howlong]").val(),
                "mudidi":$("input[name=mudidi]").val(),
                "startday":$("input[name=startday]").val(),
                "endday":$("input[name=endday]").val(),
                "jihedidian":$("input[name=jihedidian]").val(),
                "jihetime":$("input[name=jihetime]").val(),
                "price":$("input[name=price]").val(),
                "jiaotong":$("input[name=jiaotong]").val(),
                "jingdian":$("input[name=jingdian]").val(),
                "neirong":$("input[name=neirong]").val(),
                "juli":$("input[name=juli]").val(),
                "tese":$("input[name=tese]").val(),
                "qiangdu":$("input[name=qiangdu]").val(),
                "need":$("input[name=need]").val(),
                "leader":$("input[name=leader]").val(),
                "jiezhi":$("input[name=jiezhi]").val(),
                "phone":$("input[name=phone]").val(),
            };
            $("#myModal").modal('hide');
        }
        function uploadImg(t) {
            var file = t.files[0];
            if( !checkFileAllow(file,'image',4) ) {
                return false;
            }
            var fd = new FormData();
            fd.append("file" , file );
            var oXHR = new XMLHttpRequest();
            oXHR.open('POST', "/admin/uploadimg");
            oXHR.onreadystatechange = function() {
                if (oXHR.readyState == 4 && oXHR.status == 200) {
                    var d = oXHR.responseText; // 返回值
                    var img ="<div ondblclick='$(this).remove()' style='background-image: url(/admin/data/images/"+d+");' ></div>";
                    $(".pics").append(img);
                }
            }
            oXHR.send(fd);
        }

    </script>
@stop