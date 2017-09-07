@extends('admin.common')

@section("title","创建摄影大赛")

@section("content")


    <link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">
    <link rel="stylesheet" href="/admin/css/bootstrap-datetimepicker.min.css">
    <style>
        #myEditor{
            height:70vh !important;
        }
        .imgdiv{
            height:150px;width:250px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
    </style>
    <input type="text" name="title" placeholder="大赛主题" style="width:900px;margin-bottom:10px;height:35px;" ><br>
    <input class="datetimepicker"   type="text" name="title" placeholder="开始时间" style="width:300px;margin-bottom:10px;height:35px;" >
    <input class="datetimepicker"   type="text" name="title" placeholder="结束时间" style="width:300px;margin-bottom:10px;height:35px;" >
    <script type="text/plain" id="myEditor" style="width:900px;"></script>
    <input type="file" class="uploadinput2" onchange="uploadImg(this)" style="display: none;" >
    <button onclick="$('.uploadinput2').trigger('click')" style="outline:none;margin-top:10px;" type="button" class="btn btn-default">顶部图片</button>
    <button type="button" onclick="fabu()" class="btn btn-primary red" style="margin-top:10px;">确认发布</button>
    <div class="youjipics"></div>

@stop



@section("htmlend")

    <script src="/admin/js/bootstrap-datetimepicker.min.js" ></script>
    <script src="/admin/js/bootstrap-datetimepicker.zh-CN.js" ></script>

    <script src="/admin/umediter/umeditor.config.js" ></script>
    <script src="/admin/umediter/umeditor.min.js" ></script>
    <script>
        $(document).ready(function(){
            $('.datetimepicker').datetimepicker({
                "format":"yyyy-mm-dd hh:ii:ss",
                "language":"zh-CN"
            })
        })
        window.um = UM.getEditor('myEditor');
        function fabu() {
            var title = $("input[name=title]").val();
            if( $.trim(title) == '' || $.trim(um.getContentTxt()) == '' ) {
                toast("请填写没一项内容");return;
            }
            var tuwen = um.getContent();
            if( $(".youjipics").children().length == 0 ) {
                toast("请上传封面");return ;
            }
            var url = $($(".youjipics div")[0]).css("background-image");
            var pic = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];
            $.post("/admin/dofabuzixun",{"title":title,"tuwen":tuwen,"pic":pic},function(d){
                if( ajaxdata(d) ) {
                    toast("发布成功");
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