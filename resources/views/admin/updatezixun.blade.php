@extends('admin.common')
@section("title","发布徒步活动")

@section("content")



    <style>
        .imgdiv{
            height:150px;width:250px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
    </style>
    <input type="text" name="title" value="{{$data->title}}" placeholder="资讯标题" style="width:900px;margin-bottom:10px;height:35px;" >
    <textarea id="editor_id" name="content" style="width:900px;min-height:500px;">{!!$data->tuwen!!}</textarea>
    <input type="file" class="uploadinput2" onchange="uploadImg(this)" style="display: none;" >
    <button onclick="$('.uploadinput2').trigger('click')" style="outline:none;margin-top:10px;" type="button" class="btn btn-default">添加封面</button>
    <button type="button" onclick="fabu()" class="btn btn-primary red" style="margin-top:10px;">更新资讯</button>
    <div class="youjipics"></div>

@stop



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

            var img ="<div class='imgdiv' ondblclick='$(this).remove()'  style='background-image:url(/admin/data/images/{{$data->pic}})' ></div>";
            $(".youjipics").append(img);
        },1000)
        function fabu() {
            var title = $("input[name=title]").val();
            if( $.trim(title) == '' || $.trim(window.editor.html()) == '' ) {
                toast("请填写没一项内容");return;
            }
            var tuwen = window.editor.html();
            if( $(".youjipics").children().length == 0 ) {
                toast("请上传封面");return ;
            }
            var url = $($(".youjipics div")[0]).css("background-image");
            var pic = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];
            $.post("/admin/dofabuzixun",{"title":title,"tuwen":tuwen,"pic":pic,"zid":{{$data->id}}},function(d){
                if( ajaxdata(d) ) {
                    toast("操作成功");
                    location.href="/admin/zixunlist";
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