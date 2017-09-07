@extends("web.common")
@section("title","徒友动态")
@section("css")

    <style>
        .imgdiv{
            height:150px;width:150px;background-size:cover;float:left;margin-right:30px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
    </style>
@stop

@section("body")
    @include("web.header")
    <div class="content">
        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>
            <a style="color: #999;" href="/member/dongtai" >会员动态</a>
        </div>
        @for( $i=0;$i<count($list);$i++ )
            <div class="item{{$list[$i]->id}}">
                <div>{{$list[$i]->content}}</div>
                <?php $pics=explode("#",$list[$i]->imgs); ?>
                @for( $j=0;$j<count($pics);$j++ )
                    <div class="imgdiv" onclick="img2big(this)" style="background-image:url(/web/data/images/{{$pics[$j]}})" ></div>
                @endfor
                <div style="clear:both;height:20px;" ></div>
                <div style="margin-bottom:20px">
                    <a href="/user/{{$list[$i]->uid}}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/{{$list[$i]->uid}});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle" ></div></a>
                    <span>发布于 {{$list[$i]->ftime}}</span>
                    <button onclick="dongtaicmtmp({{$list[$i]->id}},'dianzan')" style="outline:none;margin-left:10px;" type="button" class="btn btn-default btn-sm">
                        <img src="/web/images/xihuan.png" style="height:18px;"><span style="margin-left:10px;" >点赞{{$list[$i]->zancnt}}</span>
                    </button>
                    <button onclick="dongtaicmtmp({{$list[$i]->id}},'liuyan')" style="outline:none;" type="button" class="btn btn-default btn-sm">
                        <img src="/web/images/liuyan.png" style="height:15px;"><span style="margin-left:10px;" >评论{{$list[$i]->cmcnt}}</span>
                    </button>
                    <button onclick="zhankai({{$list[$i]->id}},1)" style="outline:none;" type="button" class="btn btn-default btn-sm">
                        <img src="/web/images/zhankai.png" style="width:10px;"><span style="margin-left:10px;" >展开评论</span>
                    </button>
                    <div class="cmt{{$list[$i]->id}}" style="width:100%;border:1px solid #eee;margin-top:10px;display: none;" >

                    </div>
                </div>
            </div>
        @endfor
        {!! $fenye !!}
    </div>
    @include("web.footer")
    <!-- Modal -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">评论</h4>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" name="comment" rows="3" placeholder="评论内容"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button onclick="dongtaipinglun()" type="button" class="btn btn-primary">提交评论</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section("htmlend")
    <script>
        window.tmppage = [];
        // 展开评论
        function zhankai(did,flag) {
            if( flag == 1 ) {
                if($(".cmt"+did).children("div").length != 0 ) {
                    $(".cmt"+did).slideUp(function(){
                        $(".cmt"+did).children("div").remove();
                        window.tmppage[did] = 0;
                    });
                    return ;
                }
            }
            if( flag == 2 ) {
                $(".cmt"+did).children("a").remove();
            }
//            [did=>page]
            if( window.tmppage[did] ) {
                window.tmppage[did]++;
            }else{
                window.tmppage[did] = 1;
            }
            $.post("/dongtai/cmlist",{"did":did,"page":window.tmppage[did]},function(d){
                if( res = ajaxdata(d) ) {
                    if( res.length == 0 ) {
                        if( flag == 1 ) {
                            toast("还没有评论");return ;
                        }else{
                            $(".cmt"+did).children("a").remove();
                            toast("没有更多了");return ;
                        }
                    }
                    for( var i=0;i<res.length;i++ ) {
                        var cmitem = `<div style="height:30px;line-height:30px;margin:20px 10px;">
                                    <a href="/user/${res[i].uid}"><div style="display: inline-block;height:30px;width:30px;background-image:url(/head/${res[i].uid}}});background-size:cover;background-position:center;border-radius:15px;vertical-align: middle" ></div></a>
                                    <div style="display: inline-block;margin-left:10px;color:#444">${res[i].content}</div><span style="margin-left:20px;font-size:13px;color:#999;">${res[i].ctime}</span>
                                </div>`;
                        $(".cmt"+did).append(cmitem);
                    }
                    $(".cmt"+did).append("<a style='margin-left:40px;font-size:13px;text-decoration: none;margin-bottom: 10px;display: block;' href='javascript:void(0)' onclick='zhankai("+did+",2)'>加载更多</a>");
                    $(".cmt"+did).slideDown();
                }
            })
        }
        function dongtaicmtmp(did,type){
            window.dongtai_id =  did;
            if( type == 'liuyan' ) {
                $("#myModal2").modal("show");
            }else{
                dongtaicm(1);
            }
        }
        function dongtaipinglun() {
            var content = $("textarea[name=comment]").val();
            // alert(content);return;
            dongtaicm(content);
            $("#myModal2").modal("hide");
        }
        function dongtaicm(content) {
            // alert(content);return;
            $.post("/dongtai/pinglun",{"did":window.dongtai_id,"content":content},function(d){
                if(ajaxdata(d)) {
                    toast("操作成功");
                }
            })
        }
    </script>
@stop