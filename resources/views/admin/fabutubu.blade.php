@extends('admin.common')
<link rel="stylesheet" href="/web/kindeditor/themes/default/default.css">
@section("title","发布徒步活动")

@section("content")

    <div class="form-group">
        <label for="exampleInputEmail1">图文介绍 <span style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold;outline: none;" data-toggle="modal"  data-target="#myModal">活动属性</a></span><span style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold;outline: none;" onclick="$('.tubupics').slideDown()">活动图片</a></span></label>

    </div>
    <link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">

    <textarea id="editor_id" name="content" style="width:800px;min-height:600px; ">
        <style>
            .tubudetailnavbar{
                border-bottom:1px solid #ddd;width:100%;
                mpadding-bottom:10px;
            }
            .tubudetailnavbar a{
                display:block;text-decoration: none;padding:5px 10px;
                float:left;color:#333;margin-right:10px;
                cursor: pointer;font-size: 1em;
                text-align: center;background: #E6E6E6;margin-top:15px;
            }
            .tubudetailnavbar a:hover{
                background: #4B8EE8;color:#fff;
            }
        </style>

        <div class="tubudetailnavbar" >
            <a href="#xcap" >行程安排</a>
            <a href="#fysm">费用说明</a>
            <a href="#xlms">线路描述</a>
            <a href="#ditu">目的地地图</a>
            <a href="#bmxz">报名须知</a>
            <a href="#hdsp">活动视频</a>
            <a href="#xlpj">线路评价</a>
            <a href="#lydp">驴友点评</a>
            <div style="clear:both" ></div>
        </div>

        <div id="xcap" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0;text-align: left;" >
            <p>行程安排</p>
        </div>
        <br>
        <div id="fysm" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0;text-align: left;" >
            <p>费用说明</p>
        </div>
        <br>
        <div id="xlms" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0;text-align: left;" >
            <p>线路描述</p>
        </div>
        <br>
        <div id="ditu" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0;text-align: left;" >
            <p>目的地地图</p>
        </div>
        <br>
        <div id="bmxz" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0;text-align: left;" >
            <p>报名须知</p>
        </div>
        <br>
        <div id="hdsp" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0;text-align: left;" >
            <p>活动视频</p>
        </div>
        <br>
        <div id="xlpj" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0;text-align: left;" >
            <p>线路评价</p>
        </div>
        <br>
        {{--<div id="lydp" style="color:#4b8ee8;border-bottom:1px dashed #4b8ee8;font-size:20px;;margin:20px 0" >--}}
            {{--<p>驴友点评</p>--}}
        {{--</div>--}}
        {{--<br>--}}
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
                    <input type="text" value="青城山一日游" placeholder="主题" name="title" style="width: 503px !important;margin-top:10px;" name="title" ><br>
                    <input type="text" value="1" placeholder="几天" name="howlong" >
                    <input type="text" value="青城山目的地" placeholder="目的地" name="mudidi" ><br>
                    <input type="text" value="2017-09-01" placeholder="出发时间" name="startday" >
                    <input type="text" value="2017-09-02" placeholder="返回时间" name="endday" ><br>
                    <input type="text" value="火车站集合地点" placeholder="集合地点,多个集合地点使用#号隔开" name="jihedidian" >
                    <input type="text" value="2017-09-01 12:12:12" placeholder="集合时间" name="jihetime" ><br>
                    <input type="text" value="230" placeholder="价格" name="price" >
                    <input type="text" value="火车" placeholder="交通方式" name="jiaotong" ><br>
                    <input type="text" value="青城山景点" placeholder="景点" name="jingdian" >
                    <input type="text" value="活动内容你说了算" placeholder="活动内容" name="neirong" ><br>
                    <input type="text" value="200km" placeholder="距离" name="juli" >
                    <input type="text" value="特色" placeholder="特色" name="tese" ><br>
                    <input type="text" value="一般" placeholder="强度" name="qiangdu" >
                    <input type="text" value="34" placeholder="需要多少人" name="need" ><br>
                    <input type="text" value="张翠翠领队" placeholder="领队" name="leader" >
                    <input type="text" value="18328402805" placeholder="联系电话" name="phone" ><br>
                </div>
                <br>
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