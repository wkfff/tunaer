<?php

require_once dirname(__FILE__) . "/../../app/Libs/DB.php";
$handle = DB::getInstance();

$order_id = addslashes($_POST['order_id']);
$type = addslashes($_POST['type']);

if( $type == "tubu" ) {
    $sql = " select tubuorder.*,tubuhuodong.price from tubuorder inner join tubuhuodong on tubuorder.tid=tubuhuodong.id where tubuorder.id= ".$order_id;
    $res = $handle->select($sql);
    if( count($res) == 1 ) {
        $money = $res[0]['price']*$res[0]['num'];
    }else{
        echo "400-支付异常";die;
    }
}else{
    $sql = " select shoporder.*,product.price from shoporder inner join product on  shoporder.shopid=product.id where shoporder.id= ".$order_id;
    $res = $handle->select($sql);
    if( count($res) == 1 ) {
        $money = $res[0]['price']*$res[0]['num'];
    }else{
        echo "400-支付异常";die;
    }
}
$money = $money*100;
//$money = 1;

//echo "0001";
//$money = $_POST['money']*100;
// $money = 1;
//$body = $_POST['title'];
//$token = $_POST['token'];
$time = time();
$tmpArr = array(
    'appid'=>'wx10106332de6f9840',   //不要填成了 公众号原始id
    'attach'=>'成都徒哪儿户外网',
    'body'=>'成都徒哪儿户外网',
    'mch_id'=>"1490663772",
    'nonce_str'=>"vgvdfvfg54325rf",  
    'notify_url'=>'http://cdtunaer.com/openpayment/wxpay/wapnotify.php',
    'out_trade_no'=>$time."__".$order_id."__".$type,
    'spbill_create_ip'=>$_SERVER['REMOTE_ADDR'],
    'total_fee'=>$money,
    'trade_type'=>'MWEB'
    );

ksort($tmpArr);  

$buff = "";
foreach ($tmpArr as $k => $v)
{
   $buff .= $k . "=" . $v . "&";
}
$buff = trim($buff, "&");
$stringSignTemp=$buff."&key=4954bacf787c59654e7b8571831a5d38";
$sign= strtoupper(md5($stringSignTemp));
$xml = "<xml>
           <appid>wx10106332de6f9840</appid>
           <attach>成都徒哪儿户外网</attach>
           <body>成都徒哪儿户外网</body>
           <mch_id>1490663772</mch_id>
           <nonce_str>vgvdfvfg54325rf</nonce_str>
           <notify_url>http://cdtunaer.com/openpayment/wxpay/wapnotify.php</notify_url>
           <out_trade_no>".$time."__".$order_id."__".$type."</out_trade_no>
           <spbill_create_ip>".$_SERVER['REMOTE_ADDR']."</spbill_create_ip>
           <total_fee>".$money."</total_fee>
           <trade_type>MWEB</trade_type>
           <sign>".$sign."</sign>
        </xml> ";
//echo $xml;
$posturl = "https://api.mch.weixin.qq.com/pay/unifiedorder";

$ch = curl_init($posturl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_POST, 1);  
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); 
$response = curl_exec($ch);  
curl_close($ch);
//echo $response;
$xmlobj = json_decode(json_encode(simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA ))); 
exit($xmlobj->mweb_url);