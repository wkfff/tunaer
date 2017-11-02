@extends('admin.common')
<link rel="stylesheet" href="/web/kindeditor/themes/default/default.css">
@section("title","编辑摄影大赛")

@section("content")



    <link rel="stylesheet" href="/admin/css/bootstrap-datetimepicker.min.css">
    <style>

        .imgdiv{
            height:150px;width:250px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
    </style>
    <input type="text" name="title" value="{{$data->title}}" placeholder="大赛主题" style="width:900px;margin-bottom:10px;height:35px;" ><br>
    <input class="datetimepicker" value="{{$data->startday}}"  type="text" name="start" placeholder="开始时间" style="width:300px;margin-bottom:10px;height:35px;" >
    <input class="datetimepicker" value="{{$data->endday}}"  type="text" name="end" placeholder="结束时间" style="width:300px;margin-bottom:10px;height:35px;" >
    <textarea id="editor_id" name="content" style="width:900px;min-height:500px;">{!! $data->tuwen !!}</textarea>
    <input type="file" class="uploadinput2" onchange="uploadImg(this)" style="display: none;" >
    <button onclick="$('.uploadinput2').trigger('click')" style="outline:none;margin-top:10px;" type="button" class="btn btn-default">顶部图片</button>
    <button type="button" onclick="fabu()" class="btn btn-primary red" style="margin-top:10px;">保存更新</button>
    <div class="youjipics">
        <div class='imgdiv' ondblclick='$(this).remove()'  style='background-image:url(/admin/data/images/{{$data->pic}})' ></div>
    </div>

@stop



@section("htmlend")

    <script src="/admin/js/bootstrap-datetimepicker.min.js" ></script>
    <script src="/admin/js/bootstrap-datetimepicker.zh-CN.js" ></script>

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
        $(document).ready(function(){
            $('.datetimepicker').datetimepicker({
                "format":"yyyy-mm-dd hh:ii:ss",
                "language":"zh-CN"
            })
        })
//        window.um = UM.getEditor('myEditor');

        function fabu() {
            var title = $("input[name=title]").val();
            var starttime = $("input[name=start]").val();
            var endtime = $("input[name=end]").val();
            if( $.trim(starttime) == '' || $.trim(endtime) == '' || $.trim(title) == '' ) {
                toast("请填写每一项内容");return;
            }
            var tuwen = window.editor.html();
            if( $(".youjipics").children().length == 0 ) {
                toast("请上传顶部图片");return ;
            }
            var url = $($(".youjipics div")[0]).css("background-image");
            var pic = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];
            $.post("/admin/fabudasai",{"title":title,"tuwen":tuwen,"pic":pic,"startday":starttime,"endday":endtime,"id":"{{$data->id}}"},function(d){
                if( ajaxdata(d) ) {
                    toast("创建成功");
                    location.href="/admin/dasailist";
                }
            })

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
                $(".youjipics").children("div").remove();
                if (oXHR.readyState == 4 && oXHR.status == 200) {
                    var d = oXHR.responseText; // 返回值
                    var img ="<div class='imgdiv' ondblclick='$(this).remove()'  style='background-image:url(/admin/data/images/"+d+")' ></div>";
                    $(".youjipics").append(img);
                }
            }
            oXHR.send(fd);
        }
    </script>
@stop