
@extends('admin.common')

@section("content")

    <button onclick="tijiao()" type="button" class="btn btn-primary red" style="margin-bottom:10px;" >提交保存</button>
    <textarea id="editor_id" name="content" style="width:100%;min-height:600px; ">{!! $data->content !!}</textarea>

@stop

@section("htmlend")

    <script>
        KindEditor.ready(function(K) {
            window.editor = K.create('textarea[name="content"]', {
                allowImageUpload : true,
                filterMode:false
            });
        });
        function tijiao() {
            var html = window.editor.html();
            var id = "{{$data->id}}";
            $.post("/admin/updateoptions",{
                "content":html,
                "id":id
            },function(d){
                if( ajaxdata(d) ) {
                    location.reload();
                }
            })
        }
        function bianji(id) {
            $.get("/admin/getsinglepage",{"id":id},function(d){
                if( data = ajaxdata(d) ) {
                    window.editor.html(data.content);
                    $(".pagetitle").val(data.title);
                    $(".updateid").val(id);
                    $(".tubupics").slideDown();
                }
            })
        }
    </script>
@stop