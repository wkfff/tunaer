@extends("web.common")
@section("title",$data->title)
@section("css")
    <style>
        .searchb{
            width:140px;height:40px;border:none; border: 1px solid #FF0036;font-size:16px;
            letter-spacing: 4px; background:#ffeded;color: #FF0036;
            margin-right:20px;outline:none;
        }
        .searchb:active{
            opacity:0.7;color:#fff
        }
    </style>
@stop

@section("body")
    @include("web.header")
    <div class="content">

        <div style="height:160px;margin-top:20px;padding:10px;border:1px solid #ddd;" >
            <div style="height:140px;width:140px;background: dodgerblue;float:left;background-image:url(/admin/data/images/{{$data->pictures}});background-size:cover;background-position:center" ></div>
            <div style="height:140px;width:950px;;line-height:30px;float:left;margin-left:20px;" >
                <div style="font-size:18px;color:#ff536a;font-weight:bold" >{{$data->title}}</div>
                <div style="font-size:14px;margin-top:20px;" > 尺寸：{{$chicun}} 颜色：{{$color}} </div>
                <div style="font-size:14px;margin-top:5px;" >
                    数量：<input onchange="changemoney(this)" id="item_num" type="number" value="{{$num}}" style="width:70px;height:25px;text-align:center;" >　件
                </div>
            </div>
            <div style="clear:both" ></div>
        </div>
        <div class="form-group" style="margin-top:10px;">
            <label for="">联系电话</label>
            <input type="text" value="123" class="form-control phone" placeholder="联系电话">
        </div>
        <div class="form-group" >
            <label for="">收货地址</label>
            <input type="text"  class="form-control addr" placeholder="收货地址"  >
        </div>
        <div class="form-group">
            <label for="">买家留言</label>
            <input type="text" class="form-control liuyan" placeholder="买家留言">
        </div>
        <button onclick="goumai()" class="searchb" style="background:#FF0036;color:#fff;float:right;margin-right:0px;margin-top:10px;"  ><span class="glyphicon glyphicon-yen" style="margin-right:5px;" ></span>去结算</button>
        <span style="float:right;line-height:40px;font-size:20px;color:#ff536a;font-weight:bold;margin-right:30px;margin-top:10px;"><span class="money">{{$data->price}}</span> 元</span>
    </div>

    @include("web.footer")
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
                toast("操作失败"); return;
            }else{
                if(num<=0 ) {
                    toast("至少选择一件商品"); return;
                }
            }
            var addr = $(".addr").val();
            if( $.trim(addr) == '' ) {
                toast("请填写收获地址");return ;
            }
            var phone = $(".phone").val();
            if( $.trim(phone) == '' || !/^1[\d]{10}$/.test(phone) ) {
                toast("请填写正确的联系手机");return ;
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
                    location.href="/user/23#shoporder";
                }
            })

        }
    </script>
@stop