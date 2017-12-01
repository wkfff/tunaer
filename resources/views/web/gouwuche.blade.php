@extends("web.common")
@section("title","结算中心")
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
        <div class="listbox">

        </div>

        <div class="form-group" style="margin-top:10px;">
            <label for="">联系电话</label>
            <input type="text" value="" class="form-control phone" placeholder="联系电话">
        </div>
        <div class="form-group" >
            <label for="">收货地址</label>
            <input type="text" value="成都市青阳区晓峰区一栋三单元"  class="form-control addr" placeholder="收货地址"  >
        </div>
        <div class="form-group">
            <label for="">买家留言</label>
            <input type="text" class="form-control liuyan" placeholder="买家留言">
        </div>
        <button onclick="goumai()" class="searchb" style="background:#FF0036;color:#fff;float:right;margin-right:0px;margin-top:10px;"  ><span class="glyphicon glyphicon-yen" style="margin-right:5px;" ></span>去结算</button>
        <span style="float:right;line-height:40px;font-size:20px;color:#ff536a;font-weight:bold;margin-right:30px;margin-top:10px;"><span class="money"></span> 元</span>
    </div>

    @include("web.footer")
@stop

@section("htmlend")
    <script>
        $(document).ready(function(){
            loaddata();
        },100)
        function loaddata() {

            if( localStorage.getItem("gouwuche") ) {
                gouwuche = JSON.parse( localStorage.getItem("gouwuche") );
            }else{
                history.back();
            }
            for( var i=gouwuche.length-1;i>=0;i-- ) {
                var tmp = gouwuche[i].split("__");
//                var tmp = id+"__"+pic.split("#")[0]+"__"+title+"__"+price+"__"+num+"__"+color+"__"+chicun;
                var item = `<div class="shopitem" shopid="${tmp[0]}" style="height:160px;margin-top:20px;padding:10px;border:1px solid #ddd;position: relative;" >
                <div style="height:140px;width:140px;background: dodgerblue;float:left;background-image:url(/admin/data/images/${tmp[1]});background-size:cover;background-position:center" ></div>
                <div style="height:140px;width:950px;;line-height:30px;float:left;margin-left:20px;" >
                    <div style="font-size:18px;color:#ff536a;font-weight:bold" >${tmp[2]}</div>
                    <div style="font-size:14px;margin-top:20px;" > 尺寸：<i>${tmp[6]}</i> 颜色：<i>${tmp[5]}</i> </div>
                    <div style="font-size:14px;margin-top:5px;" >
                        数量：<input onchange="changemoney()" price="${tmp[3]}" id="item_num" type="number" value="${tmp[4]}" style="width:70px;height:25px;text-align:center;" >　件
                    </div>
                </div>
                <span style="color:cadetblue;font-weight:bold;font-size:20px;position: absolute;right:15px;top:15px;" >¥ ${parseFloat(tmp[3]).toFixed(2)}</span>
                <div style="clear:both" ></div>
            </div>`;
                $(".listbox").append(item);
            }
            changemoney();
        }

        function changemoney() {
            var items = $(".shopitem").find("input");
            var money = 0;
            for( var i=0;i<items.length;i++ ) {
//                console.log($(items[i]).val());
                money = money + parseInt($(items[i]).val())*parseFloat($(items[i]).attr("price"));
            }
            $(".money").text(money.toFixed(2));
        }
        window.clickxiadanlocak = false;
        function goumai() {
            if( window.clickxiadanlocak ) {
                return;
            }else{
                window.clickxiadanlocak = true;
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
            if( $.trim( parseInt( $(".money").text() ) ) == 0 ) {
                toast("至少选择一件商品");
                window.clickxiadanlocak = false;
                return;
            }
            var orders = [];
            var items = $(".shopitem");
            for( var i=0;i<items.length;i++ ) {
                var count = parseInt($(items[i]).find("input").val());
//                console.log($(items[i]).find("input").val());
                if( count >= 0 ) {
                    orders.push({
                        "shopid":$(items[i]).attr("shopid"),
                        "num":count,
                        "color":$($(items[i]).find("i")[1]).text(),
                        "chicun":$($(items[i]).find("i")[0]).text()
                    });
                }
            }

            $.post("/xiadan",
                {
                    "order":orders,
                    "addr":$(".addr").val(),
                    "liuyan":$(".liuyan").val(),
                    "phone":$(".phone").val(),
                }
                ,function(d){

                    setTimeout(function(){
                        window.clickxiadanlocak = false;
                    },5000);
                    if( ajaxdata(d) ) {
//                        console.log(orders);
                        location.href="/user/{{Session::get('uid')}}#shoporder";
                    }
                })

        }
    </script>
@stop