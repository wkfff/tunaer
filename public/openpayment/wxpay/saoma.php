<?php

$postObj = simplexml_load_string (file_get_contents("php://input"), 'SimpleXMLElement', LIBXML_NOCDATA ); 

$arr = array();
foreach ($postObj as $key => $value) { 
    $arr[$key] = $value;
} 
$pos = explode("#",$arr['product_id']);
$price = $pos[2]*100;
$order_id = $pos[0];
$type = $pos[1];
 $price = 1;
// $userid = "123";
// 这些参数可以到文档去看看  有的参数是必填 有的是选填
$tmparr = array(
   'appid'=>'wx10106332de6f9840',
   'mch_id'=>'1490663772',
   'nonce_str'=>'vgvdfvfg54325rf',
   'body'=>'成都徒哪儿户外网',
   'detail'=>'成都徒哪儿户外网',
   'product_id'=>$price,
   'trade_type'=>'NATIVE',
   'out_trade_no'=>time()."zxc".$order_id.'zxc'.$type,
   'spbill_create_ip'=>$_SERVER['REMOTE_ADDR'],
   'notify_url'=>'http://cdtunaer.com/openpayment/wxpay/saoma_notify.php',
   'total_fee'=>$price
   );
// 注意这个地方我在订单号out_trade_no上做文章了，因为支付结果异步通知到另外一个url上，
// 而那个url上只能收到订单号而不是产品编号，所以我把运载在产品编号上的信息转移到了订单号上
// 我在异步url上才能处理我的业务

// 当然你在这个页面处理业务也是可以的，比如你现在就把订单号，价格，会员信息等插入数据库，在异步url上在根据订单号查询出本次
// 订单信息，然后操作，两种放啊都是可取的
// 我这里业务简单，直接把数据寄托在订单号上了，最好是在这个页面处理一部分逻辑，在异步通知后完善逻辑

ksort($tmparr);
$buff = "";
foreach ($tmparr as $k => $v)
{
   $buff .= $k . "=" . $v . "&";
}
$buff = trim($buff, "&");

$stringSignTemp=$buff."&key=4954bacf787c59654e7b8571831a5d38";
$sign= strtoupper(md5($stringSignTemp));
$xml = "
<xml>
   <appid>wx10106332de6f9840</appid>
   <mch_id>1490663772</mch_id>
   <nonce_str>vgvdfvfg54325rf</nonce_str>
   <sign>".$sign."</sign>
   <body>成都徒哪儿户外网</body>
   <detail>成都徒哪儿户外网</detail>
   <product_id>".$price."</product_id>
   <out_trade_no>".$tmparr['out_trade_no']."</out_trade_no>
   <total_fee>".$price."</total_fee>
   <spbill_create_ip>".$_SERVER['REMOTE_ADDR']."</spbill_create_ip>
   <notify_url>http://cdtunaer.com/openpayment/wxpay/saoma_notify.php</notify_url>
   <trade_type>NATIVE</trade_type>
</xml>  
";
// die($xml);
// 调用统一下单 接口
$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder'; 
$ch = curl_init ($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
$response = curl_exec($ch);

curl_close($ch);
// 将接收到的数据直接返回，这一步官方没说明，大坑
echo $response;