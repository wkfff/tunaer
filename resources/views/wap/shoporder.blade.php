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
    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #eee;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        <span>户外商城订单</span>
    </div>
    <div class="content" style="margin-top:60px;padding:0 3px;" >
        @for( $i=0;$i<count($list);$i++ )
            <div data="{{$list[$i]->color}}&{{$list[$i]->chicun}}&{{$list[$i]->num}}#**#{{$list[$i]->addr}}#**#{{$list[$i]->liuyan}}#**#{{$list[$i]->phone}}#**#{{$list[$i]->otime}}#**#{{$list[$i]->orderid}}" style="height:120px;width:100%;position: relative;margin-bottom:20px;position: relative;" >
                <a href="/shop/detail/{{$list[$i]->shopid}}"><div style="height:100px;width:100px;position: absolute;left:0px;top:10px;background-image:url(/admin/data/images/{{$list[$i]->pictures}});background-size:cover;background-position:center;cursor: pointer;" ></div></a>
                <div style="padding-left:105px;font-size:14px;">
                    <a href="/shop/detail/{{$list[$i]->shopid}}"><span style="width:100%;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;display:inline-block;margin-top:7.5px;color:#333;">{{$list[$i]->title}}</span></a>
                    <p style="color:#666;font-size:13px;">颜色：{{$list[$i]->color}}　尺寸：{{$list[$i]->chicun}}</p>
                    <p style="color:#666;font-size:13px;">物流状态：<span style="color:#e83888">{{$list[$i]->kuaidi == 0 ? "待发货" : $list[$i]->kuaidi}}</span></p>
                </div>
                @if($list[$i]->orderid == '0')
                    <a href='javascript:void(0)' order_id='"+res[i].id+"' p='"+res[i].price+"' type='shop' onclick='payment(this,null,null)'  style='position: absolute;right:0px;bottom:5px;background: #E83888;color:#fff;display:inline-block;text-decoration: none;cursor: pointer;text-align: center;font-size:14px;padding:4px 8px;'>立即支付</a></div>
                @else
                <a href="javascript:void(0)" onclick="xiangqing(this)" style="position:absolute;right:10px;bottom:10px;"   >详情</a>
                @endif

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

    <div class="modal fade" id="paybox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <style>
                    .payimg p{
                        border: 1px solid #999;padding:10px;cursor: pointer;
                    }
                    .payimg p:hover{
                        border: 1px solid dodgerblue;
                        opacity:0.6;
                    }
                </style>
                <div class="modal-body" style="padding:40px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 style="margin-bottom:40px;">
                        请选择支付方式:
                    </h3>
                    <div class="payimg" style="width:100%;overflow-y: auto;" >
                        <p onclick="$('#payfooter').css('display','block');$('#paybox').modal('hide');$('#alipayform').submit();">支付宝<img style="cursor:pointer;vertical-align: middle;margin-left:40px;height:50px;" src="/web/images/alipay.jpg" ></p>
                        <a style="color:#333" id="wechatlink" href="#" target="_blank" onclick="$('#payfooter').css('display','block');$('#paybox').modal('hide');"><p >微信支付<img style="cursor:pointer;vertical-align: middle;margin-left:15px;height:50px;" src="/web/images/wxpay.png" ></p></a>
                        <br>
                        <div id="qrcode"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="payfooter" style="height:100%;width:100%;position:fixed;z-index:99999;left:0px;top:0px;display:none;background:#ddd;" >
        <div style="position: absolute;bottom:0px;left:0px;width:100%;height:200px;text-align:center;" >
            <button onclick="location.reload()" style="border:none;border:1px solid #fff;color:#fff;height:80px;width:80%;background: #e83888;font-size:1.5em;margin:10px 0;">支付成功</button>
            <button onclick="location.reload()" style="border:none;border:1px solid #fff;color:#000;height:80px;width:80%;background: darkgrey;font-size:1.5em">返回</button>
        </div>
    </div>

    <!-- 支付宝form -->
    <form id="alipayform" style="display:none" action='/openpayment/alipay.php' method="POST" target="_blank" >
        <div id="body" style="clear:left">
            <dl class="content">
                <dt>商户订单号：</dt>
                <dd>
                    <input id="WIDout_trade_no" name="WIDout_trade_no" />
                </dd>
                <hr class="one_line">
                <dt>订单名称：</dt>
                <dd>
                    <input id="WIDsubject" name="WIDsubject" />
                </dd>
                <hr class="one_line">
                <dt>付款金额：</dt>
                <dd>
                    <input id="WIDtotal_amount" name="WIDtotal_amount" />
                </dd>
                <hr class="one_line">
                <dt>商品描述：</dt>
                <dd>
                    <input id="WIDbody" name="WIDbody" />
                </dd>
                <hr class="one_line">
                <dt></dt>
                <dd id="btn-dd">
                <span class="new-btn-login-sp">
                    <button class="new-btn-login" type="submit" style="text-align:center;">确 认</button>
                </span>
                </dd>
            </dl>
        </div>
    </form>


    <form id="wxpayform" style="display:none" action='/openpayment/wxpay_sdk/example/jsapi.php' method="GET"  >
        <input  name="order_id" />
        <input  name="type" />
    </form>

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