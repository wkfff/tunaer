@extends('admin.common')
<link rel="stylesheet" href="/web/kindeditor/themes/default/default.css">
@section("title","发布商品")

@section("content")

<div class="form-group">
    <label for="exampleInputEmail1">图文介绍 <span style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold;outline: none;" data-toggle="modal"  data-target="#myModal">商品属性</a></span><span style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold;outline: none;" onclick="$('.datapics').slideDown()">商品图片</a></span></label>

</div>
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
                <h4 class="modal-title" id="myModalLabel">商品属性</h4>
            </div>
            <style>
                #inputcls input{
                    height:30px !important;width:250px !important;border: none !important;border:1px solid #999 !important;
                }
            </style>
            <div class="modal-body">
                <div id="inputcls">
                    <input type="text" value="{{$data->title}}" placeholder="商品名称" name="title" style="width: 503px !important;margin-top:10px;" ><br>

{{--                    <input type="text" value="{{$data->sort}}" placeholder="大分类" name="sort" >--}}
{{--                    <input type="text" value="{{$data->subsort}}" placeholder="小分类" name="sort" >--}}
                    <input type="text" value="{{$data->price}}" placeholder="价格" name="price" >
                    <input type="text" value="{{$data->sold}}" placeholder="已售多少" name="sold" ><br>
                    <input type="text" value="{{$data->colorlist}}" placeholder="颜色列表" name="colorlist" >
                    <input type="text" value="{{$data->chicunlist}}" placeholder="尺寸列表" name="chicunlist" ><br>
                    <input type="text" value="{{$data->youfei}}" placeholder="邮费" name="youfei" >
                    <input type="text" value="{{$data->kucun}}" placeholder="库存" name="kucun" ><br>
                    <select class="form-control" onchange="loadsubsort(this)" name="sort" style="width:250px;display: inline-block;">
                        <option value="">===大分类===</option>

                    </select>
                    <select class="form-control" name="subsort" style="width:250px;display: inline-block;">
                        <option value="">===小分类===</option>
                    </select>
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
<div class="datapics" onclick="$(this).slideUp()" style="width:100%;height: 100%;position:fixed;z-index:9999;left:0px;top:0px;display:none" >

    <div onclick="zuzhi(event)" style="width:1000px;height:570px;background:white;position:absolute;top:50%;left:50%;
        margin-left:-500px;margin-top:-285px;box-shadow:1px 3px 15px rgba(0,0,0,0.8);overflow-y: auto;padding:10px;  " >
        <button onclick="$('.uploadfengmian').trigger('click');zuzhi(event);" type="button" class="btn btn-primary" style="position:absolute;top:10px;right:10px;" >添加图片</button>
        <input class="uploadfengmian" type="file" style="display: none;" onchange="uploadImg(this)">
        <button onclick="$('.datapics').slideUp();" type="button" class="btn btn-primary red" style="position:absolute;top:60px;right:10px;" >立即保存</button>
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
    setTimeout(function () {
        window.editor.html(`{!!$data->tuwen!!}`);

        var imgs = '{{$data->pictures}}';
        var imgs = imgs.split("#");
        for( var j=0;j<imgs.length;j++ ) {
            var img ="<div ondblclick='$(this).remove()' style='background-image: url(/admin/data/images/"+imgs[j]+");' ></div>";
            $(".pics").append(img);
        }

        loadfenlei();
        $("select[name=sort]").val("{{$data->sort}}");
        $("select[name=sort]").trigger('change');
        $("select[name=subsort]").val("{{$data->subsort}}");
//            加载属性
        save();

    },100)
    function fabu() {
        var t1 = $("#inputcls input");
        for( var i=0;i<t1.length;i++ ) {
//            console.log(t1[i].value);
            if( t1[i].value == '' ) {
                toast("属性不完整"); return ;
            }
        }
        var sort = $("select[name=sort]").val();
        var subsort = $("select[name=subsort]").val();
        if( sort =='' || subsort == '') {
            toast("属性不完整"); return ;
        }
        if( checkpictures() ) {
            window.shuxing.tuwen = window.editor.html();
            window.shuxing.pid = '{{$data->id}}';
            $.post("/admin/doupdateproduct",window.shuxing,function(data){
                if( ajaxdata(data) ) {
                    toast("更新成功");
                    location.href="/admin/productlist";
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
//    <option value=''>大分类</option>
    function loadfenlei () {
        window.data = eval({!! $fenlei !!});

        for( var i=0;i<data.length;i++ ) {
            if( $('.sort'+data[i].id).length == 0 ) {
                $("select[name=sort]").append("<option class='sort"+data[i].id+"' value='"+data[i].id+"'>"+data[i].title+"</option>")
            }
        }

    }
    function loadsubsort(that) {
        $("select[name=subsort]").children().remove();
        var sort = $(that).val();
        for( var i=0;i<data.length;i++ ) {
            if( data[i].id == sort ) {
                $("select[name=subsort]").append("<option class='subsort"+data[i].subid+"' value='"+data[i].subid+"'>"+data[i].subtitle+"</option>")
            }
        }
    }
    function save() {
        var sort = $("select[name=sort]").val();
        var subsort = $("select[name=subsort]").val();
        window.shuxing = {

            "title":$("input[name=title]").val(),
            "sort":sort,
            "subsort":subsort,
            "price":$("input[name=price]").val(),
            "sold":$("input[name=sold]").val(),
            "colorlist":$("input[name=colorlist]").val(),
            "chicunlist":$("input[name=chicunlist]").val(),
            "youfei":$("input[name=youfei]").val(),
            "kucun":$("input[name=kucun]").val(),
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