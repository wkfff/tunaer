@extends('admin.common')

@section("title","发布徒步活动")

@section("content")

    <div cdiss="form-group">
        <label for="exampleInputEmail1">图文介绍 <span id="ceshi" style="margin-left:20px;"><a href="javascript:void(0)" style="color:#ff536a;font-weight:bold" data-toggle="modal"  data-target="#myModal">活动属性</a></span></label>
    </div>
    <link rel="stylesheet" href="/admin/umediter/css/umeditor.min.css">

    <script type="text/plain" id="myEditor" style="width:100%;height:70vh;"></script>
    <button type="button" class="btn btn-primary red" style="margin-top:10px;">确认发布</button>
    <!-- Modal -->
    <div class="modal fade" id="myModal" style="width:500px" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:100%">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">活动属性</h4>
                </div>
                <div class="modal-body">
                    <div style="width:200px;height:140px;background-image:url(/web/images/p1.jpg);background-size:cover;background-position:center;margin-bottom: 10px" ></div>
                    <input type="radio" name="type" >短途
                    <input type="radio" name="type" >长途
                    <input type="radio" name="type" >自驾游
                    <input type="radio" name="type" >团队徒步
                    <input type="radio" name="type" >成都周边
                    <input type="text" placeholder="主题" style="width: 450px;margin-top:10px;" name="title" ><br>
                    <input type="text" placeholder="几天" name="day" >
                    <input type="text" placeholder="目的地" name="mudidi" ><br>
                    <input type="text" placeholder="出发时间" name="startday" >
                    <input type="text" placeholder="返回时间" name="endday" ><br>
                    <input type="text" placeholder="集合地点" name="jihedidian" >
                    <input type="text" placeholder="集合时间" name="jihetime" ><br>
                    <input type="text" placeholder="价格" name="price" >
                    <input type="text" placeholder="交通方式" name="jiaotong" ><br>
                    <input type="text" placeholder="景点" name="jingdian" >
                    <input type="text" placeholder="活动内容" name="neirong" ><br>
                    <input type="text" placeholder="强度" name="qiangdu" >
                    <input type="text" placeholder="需要多少人" name="need" ><br>
                    <input type="text" placeholder="领队" name="leader" >
                    <input type="text" placeholder="联系电话" name="phone" ><br>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" onclick="save()" class="btn btn-primary">保存设置</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section("js")

    <script src="/admin/umediter/umeditor.config.js" ></script>
    <script src="/admin/umediter/umeditor.min.js" ></script>
    <script>
        var um = UM.getEditor('myEditor');
//        $("#ceshi a").trigger("click");
    </script>
@stop