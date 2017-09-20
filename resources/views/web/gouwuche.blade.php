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
        <span style="float:right;line-height:40px;font-size:20px;color:#ff536a;font-weight:bold;margin-right:30px;margin-top:10px;"><span class="money">1231</span> 元</span>
    </div>

    @include("web.footer")
@stop

@section("htmlend")
    <script>
        $(document).ready(function(){
            loaddata();
        },100)
        function changemoney(that) {
            $(".money").text($(that).val()*23);
        }

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
                    <div style="font-size:14px;margin-top:20px;" > 尺寸：${tmp[6]} 颜色：${tmp[5]} </div>
                    <div style="font-size:14px;margin-top:5px;" >
                        数量：<input onchange="changemoney(this)" id="item_num" type="number" value="${tmp[4]}" style="width:70px;height:25px;text-align:center;" >　件
                    </div>
                </div>
                <span style="color:cadetblue;font-weight:bold;font-size:20px;position: absolute;right:15px;top:15px;" >¥ ${tmp[3]}</span>
                <div style="clear:both" ></div>
            </div>`;
                $(".listbox").append(item);
            }
        }
    </script>
@stop