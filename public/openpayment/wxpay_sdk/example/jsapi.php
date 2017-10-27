<?php

ini_set('date.timezone','Asia/Shanghai');

require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";

require_once dirname(__FILE__) . "/../../../../app/Libs/DB.php";
$handle = DB::getInstance();

$order_id = $_GET['order_id'];
$type = $_GET['type'];
$time = time();

if( $type == "tubu" ) {
    $sql = " select tubuorder.*,tubuhuodong.price,tubuhuodong.title from tubuorder inner join tubuhuodong on tubuorder.tid=tubuhuodong.id where tubuorder.id= ".$order_id;
    $res = $handle->select($sql);
    if( count($res) == 1 ) {
        $money = $res[0]['price'];
        $title = $res[0]['title'];
    }else{
        echo "400-支付异常";die;
    }
}else{
    $sql = " select shoporder.*,product.price,product.title from shoporder inner join shoporder.shopid=product.id where shoporder.id= ".$order_id;
    $res = $handle->select($sql);
    if( count($res) == 1 ) {
        $money = $res[0]['price'];
        $title = $res[0]['title'];
    }else{
        echo "400-支付异常";die;
    }
}
$money = 0.1;

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("成都徒哪儿户外网");
$input->SetAttach("成都徒哪儿户外网");
$input->SetOut_trade_no($time."__".$order_id."__".$type);
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("成都徒哪儿户外网");
$input->SetNotify_url("http://cdtunaer.com/openpayment/wxpay_sdk/example/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

?>

<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付样例-支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
//			    if( res.err_msg == "get_brand_wcpay_request:ok" ) {
//                    echo "支付成功：　<a href='/' >返回首页</a>";
//                }else{
//                    echo "支付失败：　<a href='/' >返回首页</a>";
//                }

//				WeixinJSBridge.log(res.err_msg);
				alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
//				alert(value1 + value2 + value3 + value4 + ":" + tel);
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	
	</script>
</head>
<body>
    <br/>
    <h3 style="color:#333">
        <?php echo $title; ?>
    </h3>
    <h2  style="color:#e83888;font-size:2em;font-weight: bold;">
        <?php echo "￥".$money; ?>
    </h2>
<!--    <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/>-->
    <div align="center">
        <button style="width:100%; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
    </div>

</body>
</html>