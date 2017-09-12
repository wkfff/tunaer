@extends("admin.common")

@section("title","徒步活动列表")
<style>
    .sort{
        border:1px solid #eee;padding:20px;margin:10px 0px;
    }
    .sort p{
        font-size:20px;color:#444;border-bottom:1px solid #999;padding-bottom:10px;
    }
    .sort a{
        font-size:15px;color:dodgerblue;display: inline-block;min-width:100px;background:rgba(0,0,0,0.1);
        height:40px;line-height:40px;text-align: center;
        text-decoration: none !important;margin-right:10px;
    }
</style>
@section("content")




    <div class="sortbox" >
        {{--<div class='sort'>--}}
            {{--<p href='#' >登山鞋</p>--}}
            {{--<a href='#'>男鞋</a>--}}
            {{--<a href='#'>女鞋</a>--}}
        {{--</div>--}}
    </div>

    <div style="margin-top:20px;">
        <button onclick="addsort()" class="btn btn-default" >新增分类</button>
        <span style="margin-left:20px;line-height:30px;color:red;">子分类双击分类删除</span>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="myModal" style="display: none;" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">新增分类</h4>
                </div>
                <style>
                    #inputcls input{
                        height:30px !important;width:250px !important;border: none !important;border:1px solid #999 !important;
                    }
                    .pics div{
                        width:240px;height:150px;margin:5px;background-repeat:no-repeat;
                        float: left;background-position: center;
                        background-size:cover;
                    }

                </style>
                <div class="modal-body">
                    <div id="inputcls">
                        <input type="text" value="" placeholder="分类名" name="title"  ><br>
                        <input type="text" value="10" placeholder="排序" name="sort"  >（ 1-100,值大的排名更靠前）<br>
                        <input type="text" value="" placeholder="父类id" name="pid"  ><br>
                        <input type="hidden" value="" name="id">
                        <span>（要创建新父类，id值填留空）</span>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <span style="float:left;margin-left:10px;margin-top:10px;" ></span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" onclick="fabu()" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </div>


@stop

@section("htmlend")
    <script>
        var data = eval({!! $fenlei !!});
        for( var i=0;i<data.length;i++ ) {
            if( $(".sort"+data[i].id).length == 0 ) {
                $(".sortbox").append("<div sort="+data[i].sort+" title='"+data[i].title+"' id="+data[i].id+" class='sort sort"+data[i].id+"'><p>"+data[i].title+" ( id : "+data[i].id+" ) ( 排序 : "+data[i].sort+") <span style='color:dodgerblue;font-size:16px;cursor:pointer;float:right' table='shopsort' onclick='deletebyid(this,"+data[i].id+")'>删除</span>　<span style='color:dodgerblue;font-size:16px;cursor:pointer;float:right;margin-right:10px;' table='shopsort' onclick='modify("+data[i].id+")'>修改</span></p></div>");
                for( var j=0;j<data.length;j++ ) {
                    if( data[j].pid == data[i].id) {
                        $(".sort"+data[j].pid).append("<a table='shopsubsort' ondblclick='deletebyid(this,"+data[j].subid+")' href='javascript:void(0)'>"+data[j].subtitle+"</a>");
                    }
                }
            }
        }
//        addsort();
        function addsort() {
            $("#myModal").modal("show");
            $("input[name=pid]").removeAttr("disabled");
        }

        function fabu() {
            var title = $("input[name=title]").val();
            var sort = $("input[name=sort]").val();
            var pid = $("input[name=pid]").val();
            var id = $("input[name=id]").val();
            $.post("/admin/addshopsort",{"title":title,"sort":sort,"pid":pid,"id":id},function(d){
                if( ajaxdata(d) ) {
                    location.reload(true);
                }
            })
        }

        function deletebyid(that,id) {
//            alert($(that).attr('table'));return;
            if( confirm("删除后不可撤销") ) {
                $.post("/admin/deletebyid",{
                    "table":$(that).attr('table'),
                    "id":id
                },function(data){
                    location.reload();
                })
            }

        }

        function modify(sortid) {
            $("#myModal").modal("show");
            $("input[name=title]").val($(".sort"+sortid).attr('title'));
            $("input[name=sort]").val($(".sort"+sortid).attr('sort'));
            $("input[name=id]").val($(".sort"+sortid).attr('id'));
            $("input[name=pid]").val('');
            $("input[name=pid]").attr("disabled","true");
        }

    </script>
@stop