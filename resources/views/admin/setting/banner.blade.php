@extends("admin.common")

@section("title","徒步活动列表")

@section("content")

    <table class="table">
        <thead>
        <tr>
            <th>编号</th>
            <th>标题</th>
            <th>图片</th>
            <th>链接</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($list); $i++)
            <tr class="test{{$list[$i]->id}}">
                <td class="center">{{$list[$i]->id}}</td>
                <td class="center">{{$list[$i]->title}}</td>

                <td class="center" url="{{$list[$i]->pic}}"><div onclick="img2big(this)" style="background-image:url(/admin/data/images/{{$list[$i]->pic}});background-position:center;background-repeat:no-repeat;background-size:cover;width:30px;height:20px;" ></div></td>
                <td class="center">{{$list[$i]->url}}</td>
                <td class="center">{{$list[$i]->sort}}</td>
                <td class="center">
                    <li class="dropdown user" style="list-style: none">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">操作</span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:updatebyid({{$list[$i]->id}})">修改</a></li>
                            <li><a href="javascript:deletebyid({{$list[$i]->id}})">删除</a></li>
                        </ul>
                    </li>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
    <div>
        <button onclick="addtype()" class="btn btn-primary red" >添加Banner</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" style="display: none;" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">参数</h4>
                </div>
                <style>
                    #inputcls input{
                        height:30px !important;width:90%;border: none !important;border:1px solid #999 !important;
                    }
                    .pics div{
                        width:240px;height:150px;margin:5px;background-repeat:no-repeat;
                        float: left;background-position: center;
                        background-size:cover;
                    }

                </style>
                <div class="modal-body">
                    <div id="inputcls">
                        <input type="text" value="" placeholder="标题" name="title"  ><br>
                        <input type="text" value="" placeholder="链接 http://baidu.com" name="url"  ><br>
                        <input type="text" value="1" placeholder="排序 数值越大越靠前" name="sort"  ><br>
                        <div class="pics"  >

                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <input class="uploadfengmian" type="file" style="display: none;" onchange="uploadImg(this)">
                    <button onclick="$('.uploadfengmian').trigger('click');zuzhi(event);" type="button" class="btn btn-primary" style="float:left" >添加顶部图片</button>
                    <span style="float:left;margin-left:10px;margin-top:10px;" >双击图片删除</span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" onclick="fabu()" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </div>


@stop

@section("htmlend")

    <script >
        function uploadImg(t) {
            var file = t.files[0];
            if( !checkFileAllow(file,'image',10) ) {
                return false;
            }
            var fd = new FormData();
            fd.append("file" , file );
            var oXHR = new XMLHttpRequest();
            oXHR.open('POST', "/admin/uploadimg");
            oXHR.onreadystatechange = function() {
                $(".pics").children("div").remove();
                if (oXHR.readyState == 4 && oXHR.status == 200) {
                    var d = oXHR.responseText; // 返回值
                    var img ="<div ondblclick='$(this).remove()' style='background-image: url(/admin/data/images/"+d+")' ></div>";
                    $(".pics").append(img);
                }
            }
            oXHR.send(fd);
        }
        function fabu() {
            var t1 = $("#inputcls input");
            window.shuxing.title = $("input[name=title]").val();
            window.shuxing.sort = $("input[name=sort]").val();
            window.shuxing.url = $("input[name=url]").val();

            if( shuxing.title == '' || shuxing.sort == '' || shuxing.url == '' ) {
                toast("有未填项");return ;
            }
            if( checkpictures() ) {
                $.post("/admin/setting/banner",window.shuxing,function(data){
                    if( ajaxdata(data) ) {
                        toast("操作成功");
                        location.reload();
                    }
                })
            }


        }
        function checkpictures() {
            var pics = $(".pics div");
            if( pics.length == 0 ) {
                toast("缺少图片"); return false;
            }
            var url = $(pics[0]).css("background-image");
            window.shuxing.pic = url.split('/').pop().match(/(\d+\.[a-zA-Z]+)\"\)/)[1];
            return true;
        }
        function addtype() {
            $(".pics").children("div").remove();
            window.shuxing = {};
            $('#myModal').modal("show");
        }
        function updatebyid(id) {
            $('#myModal').modal("show");
            var title = $($(".test" + id).children("td")[1]).text();
            var img = $($(".test" + id).children("td")[2]).attr('url');
            var url = $($(".test" + id).children("td")[3]).text();
            var sort = $($(".test" + id).children("td")[4]).text();

            $($("#inputcls input")[0]).val(title);
            $($("#inputcls input")[1]).val(url);
            $($("#inputcls input")[2]).val(sort);
//            $("#inputcls textarea").val(intro);
            $(".pics").children("div").remove();
            var img ="<div ondblclick='$(this).remove()' style='background-image: url(/admin/data/images/"+img+")' ></div>";
            $(".pics").append(img);
            window.shuxing = {
                id:id
            }
        }
        function deletebyid(tid) {
            $.post("/admin/deletebyid",{
                "table":"banner",
                "id":tid
            },function(data){
                location.reload();
            })
        }
    </script>
@stop