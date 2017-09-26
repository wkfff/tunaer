@extends("wap.common")
@section("title","户外商城订单")
@section("css")

    <style>
        .imgdiv{
            height:100px;width:100px;background-size:cover;float:left;margin-right:10px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:45px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:45px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:45px;" class="glyphicon glyphicon-menu-left" ></span>
        <span>户外商城订单</span>
    </div>
    <div class="content" style="margin-top:50px;padding:0 3px;" >
        @for( $i=0;$i<count($list);$i++ )
            <div data="{{$list[$i]->color}}&{{$list[$i]->chicun}}&{{$list[$i]->num}}#**#{{$list[$i]->addr}}#**#{{$list[$i]->liuyan}}#**#{{$list[$i]->phone}}#**#{{$list[$i]->otime}}#**#{{$list[$i]->orderid}}" style="height:120px;width:100%;position: relative;margin-bottom:20px;position: relative;" >
                <a href="/shop/detail/{{$list[$i]->shopid}}"><div style="height:100px;width:100px;position: absolute;left:0px;top:10px;background-image:url(/admin/data/images/{{$list[$i]->pictures}});background-size:cover;background-position:center;cursor: pointer;" ></div></a>
                <div style="padding-left:105px;font-size:14px;">
                    <a href="/shop/detail/{{$list[$i]->shopid}}"><span style="width:100%;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;margin-top:7.5px;color:#333;">{{$list[$i]->title}}</span></a>
                    <p style="color:#666;font-size:13px;">颜色：{{$list[$i]->color}}　尺寸：{{$list[$i]->chicun}}</p>
                    <p style="color:#666;font-size:13px;">物流状态：<span style="color:#e83888">{{$list[$i]->kuaidi == 0 ? "准备发货" : $list[$i]->kuaidi}}</span></p>
                    {{--<p style="color:#666;font-size:13px;margin-top:-5px;width:100%;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;">留言：{{$list[$i]->liuyan}}　</p>--}}
                </div>
                <a href="javascript:void(0)" onclick="xiangqing(this)" style="position:absolute;right:10px;bottom:10px;"   >详情</a>
            </div>
        @endfor

        {!! $fenye !!}

    </div>

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:100%">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">订单详情</h4>
                </div>
                <div class="modal-body">
                    <p class="orderid" style="color: #e83888;" ></p>
                    <p>颜色&尺寸&件数：</p>
                    <p class="props" style="min-height:10px;"></p>
                    <p>收获地址：</p>
                    <p class="addr" style="min-height:10px;"></p>

                    <p>联系电话：</p>
                    <p class="phone" style="min-height:10px;"></p>
                    <p>留言：</p>
                    <p class="liuyan" style="min-height:10px;"></p>
                </div>
                <div class="modal-footer">
                    <span style="float:left;font-size:12px;line-height:30px;" class="ordertime" ></span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
                    {{--<button type="button" class="btn btn-primary">确定</button>--}}
                </div>
            </div>
        </div>
    </div>

    @include("wap.footer")

@stop

@section("htmlend")
    <script>
        function xiangqing(that) {
            var data = $(that).parent("div").attr("data");
            var tmp = data.split("#**#");
            $(".props").text(tmp[0]);
            $(".addr").text(tmp[1]);
            $(".liuyan").text(tmp[2]);
            $(".phone").text(tmp[3]);
            $(".ordertime").text("下单时间："+tmp[4]);
            $(".orderid").text("订单号："+tmp[5]);
            $("#myModal2").modal("show");
        }
    </script>

@stop