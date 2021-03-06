@extends('admin.common')

@section("title","修改活动")

@section("content")

    <div class="form-group">
        <label for="exampleInputEmail1">图文介绍 <span style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold;outline: none;" data-toggle="modal"  data-target="#myModal">活动属性</a></span><span style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold;outline: none;" onclick="$('.tubupics').slideDown()">活动图片</a></span></label>

    </div>
    <link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">
    <style>
        #myEditor{
            height:70vh !important;
        }
    </style>
    <textarea id="editor_id" name="content" style="width:900px;min-height:600px; "></textarea>
    {{--<script type="text/plain" id="myEditor" style="width:900px;"></script>--}}
    <button type="button" onclick="fabu()" class="btn btn-primary red" style="margin-top:10px;">更新保存</button>

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
                    <input type="text" value="{{$tubu->title}}" placeholder="主题" name="title" style="width: 503px !important;margin-top:10px;" name="title" ><br>
                    <input type="text" value="{{$tubu->howlong}}" placeholder="几天" name="howlong" >
                    <input type="text" value="{{$tubu->mudidi}}" placeholder="目的地" name="mudidi" ><br>
                    <input type="text" value="{{$tubu->startday}}" placeholder="出发时间 格式:2017-12-15" name="startday" >
                    <input type="text" value="{{$tubu->endday}}" placeholder="返回时间" name="endday" ><br>
                    <input type="text" value="{{$tubu->jihedidian}}" placeholder="集合地点,多个集合地点使用#号隔开" name="jihedidian" >
                    <input type="text" value="{{$tubu->jihetime}}" placeholder="集合时间" name="jihetime" ><br>
                    <input type="text" value="{{$tubu->price}}" placeholder="价格" name="price" >
                    <input type="text" value="{{$tubu->jiaotong}}" placeholder="交通方式" name="jiaotong" ><br>
                    <input type="text" value="{{$tubu->jingdian}}" placeholder="景点" name="jingdian" >
                    <input type="text" value="{{$tubu->neirong}}" placeholder="活动内容" name="neirong" ><br>
                    <input type="text" value="{{$tubu->juli}}" placeholder="距离" name="juli" >
                    <input type="text" value="{{$tubu->tese}}" placeholder="特色请用#号隔开" name="tese" ><br>
                    <input type="text" value="{{$tubu->qiangdu}}" placeholder="强度" name="qiangdu" >
                    <input type="text" value="{{$tubu->need}}" placeholder="需要多少人" name="need" ><br>
                    <input type="text" value="{{$tubu->leader}}" placeholder="领队" name="leader" >
                    <input type="text" value="{{$tubu->phone}}" placeholder="联系电话" name="phone" ><br>
                    <input type="text" style="width:504px !important;" value="{{$tubu->jiezhi}}" placeholder="报名截止时间 格式:2017-12-15 09:30:00" name="jiezhi" ><br>
                    <input type="text" style="width:504px !important;" value="{{$tubu->shuoming}}" placeholder="报名截止时间 格式:2017-12-15 09:30:00" name="shuoming" ><br>
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
        setTimeout(function () {
            window.editor.html(`{!!$tubu->tuwen!!}`);
            var inputs = $("input[name=types]");
            inputs.removeAttr("checked");
            var types = '{{$tubu->types}}';
            for( var i=0;i<inputs.length;i++ ) {
                if( inputs[i].value == types ) {
                    $(inputs[i]).prop("checked","true");
                }
            }
            var imgs = '{{$tubu->pictures}}';
            var imgs = imgs.split("#");
            for( var j=0;j<imgs.length;j++ ) {
                var img ="<div ondblclick='$(this).remove()' style='background-image: url(/admin/data/images/"+imgs[j]+");' ></div>";
                $(".pics").append(img);
            }
//            加载属性
            save();
        },1000)

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
                window.shuxing.tubuid = '{{$tubu->id}}';
                $.post("/admin/doupdatetubu",window.shuxing,function(data){
                    if( ajaxdata(data) ) {
                        toast("更新成功");
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
                "shuoming":$("input[name=shuoming]").val(),
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