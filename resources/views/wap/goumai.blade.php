@extends("wap.common")
@section("title","确认订单")
@section("css")

    <style>
        .imgdiv{
            height:100px;width:100px;background-size:cover;float:left;margin-right:10px;
            background-position:center;background-repeat: no-repeat;margin-top:10px;
        }
        .searchb{
            width:140px;height:40px;border:none; border: 1px solid #FF0036;font-size:16px;
            letter-spacing: 4px; background:#ffeded;color: #FF0036;
            margin-right:20px;outline:none;
        }
        .shopitem{
            height:130px;width:100%;margin-bottom:10px;
            padding:10px 5px;background: white;
            position: relative;
        }
        .shoppic{
            height:200px;width:100%;background-position:center;background-size:cover;float:left;
            /*margin-right:10px;*/
        }
    </style>
@stop

@section("body")
    <div  style="width:100%;height:45px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:45px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:45px;" class="glyphicon glyphicon-menu-left" ></span>
        <span>提交订单</span>
    </div>
    <div class="content" style="margin-top:50px;" >

        <div style="height:160px;margin-top:20px;" >
            <a href="/shop/detail/{{$data->id}}">
                <div class="shoppic" style="background-image:url(/admin/data/images/{{$data->pictures}});" ></div>
            </a>
            <div style="height:140px;width:100%;line-height:30px;float:left;padding:10px;" >
                <div style="font-size:18px;color:#ff536a;font-weight:bold;margin-top:10px;" >{{$data->title}}</div>
                <div style="font-size:14px;margin-top:10px;" > 尺寸：{{$chicun}} 颜色：{{$color}} </div>
                <div style="font-size:14px;margin-top:5px;" >
                    数量：<input onchange="changemoney(this)" id="item_num" type="number" value="{{$num}}" style="width:70px;height:25px;text-align:center;" >　件
                </div>
            </div>
            <div style="clear:both" ></div>
        </div>
        <div style="clear:both;height:10px;" ></div>
        <div class="form-group" style="margin:10px;">
            <label for="">联系电话</label>
            <input type="text" value="" class="form-control phone" placeholder="联系电话">
        </div>
        <div class="form-group"  style="margin:10px;">
            <label for="">收货地址</label>
            <input type="text"  class="form-control addr" value="" placeholder="收货地址"  >
        </div>
        <div class="form-group" style="margin:10px;">
            <label for="">买家留言（<span style="color:red">请至少备注你的姓名</span>）</label>
            <input type="text" class="form-control liuyan" placeholder="买家留言">
        </div>
        <div class="form-group" style="margin:10px;">

            <span style="float:right;line-height:40px;font-size:20px;color:#ff536a;font-weight:bold;margin-right:30px;"><span class="money">{{$data->price}}</span> 元</span>
            <span class="glyphicon glyphicon-yen" style="color:#ff536a;line-height:40px;float:right;margin-right:5px;margin-top:-2px;" ></span>
            <input type="submit" onclick="goumai()" class="form-control " value="去付款" style="background:#ff536a;color:#fff;height:40px;">

        </div>

        <span style="float:right;line-height:40px;font-size:20px;color:#ff536a;font-weight:bold;margin-right:30px;margin-top:10px;"><span class="money">{{$data->price}}</span> 元</span>
    </div>

    @include("wap.footer")
@stop

@section("htmlend")
    <script>
        function changemoney(that) {
            $(".money").text($(that).val()*{{$data->price}});
        }
        window.clickxiadanlocak = false;
        function goumai() {
            if( window.clickxiadanlocak ) {
                return;
            }else{
                window.clickxiadanlocak = true;
            }
            var num = $("#item_num").val();
            if( !/^[\d]+$/.test(num) ) {
                $("#item_num").val(1);
                toast("操作失败");
                window.clickxiadanlocak = false;
                return;
            }else{
                if(num<=0 ) {
                    toast("至少选择一件商品");
                    window.clickxiadanlocak = false;
                    return;
                }
            }
            var addr = $(".addr").val();
            if( $.trim(addr) == '' ) {
                toast("请填写收获地址");
                window.clickxiadanlocak = false;
                return ;
            }
            var phone = $(".phone").val();
            if( $.trim(phone) == '' || !/^1[\d]{10}$/.test(phone) ) {
                toast("请填写正确的联系手机");
                window.clickxiadanlocak = false;
                return ;
            }
            $.post("/xiadan",
                {
                    "order":[
                        {
                            "shopid":{{$data->id}},
                            "num":num,
                            "color":"{{$color}}",
                            "chicun":"{{$chicun}}"
                        }
                    ],
                    "addr":$(".addr").val(),
                    "liuyan":$(".liuyan").val(),
                    "phone":$(".phone").val(),
                }
                ,function(d){
                    setTimeout(function(){
                        window.clickxiadanlocak = false;
                    },10000);
                    if( ajaxdata(d) ) {
                        location.href="/shoporder";
                    }
                })

        }
    </script>
@stop