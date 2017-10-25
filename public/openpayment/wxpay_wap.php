<?php


$money = $_POST['money']*100;
// $money = 1;
$body = $_POST['title'];
$token = $_POST['token'];
$time = time();
$tmpArr = array(
    'appid'=>'wx31ffe118466ac333',   //不要填成了 公众号原始id
    'attach'=>'尊城情缘',
    'body'=>$body,
    'mch_id'=>"1464027602",
    'nonce_str'=>"vgvdfvfg54325rf",  
    'notify_url'=>'http://www.zcqy520.com/openpayment/wxpay/wapnotify.php',
    'out_trade_no'=>$time."__".substr($token,0,10), 
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
$stringSignTemp=$buff."&key=51b3363e91fe317fc346526f5933f15e";
$sign= strtoupper(md5($stringSignTemp));
$xml = "<xml>
           <appid>wx31ffe118466ac333</appid>
           <attach>尊城情缘</attach>
           <body>".$body."</body>
           <mch_id>1464027602</mch_id>
           <nonce_str>vgvdfvfg54325rf</nonce_str>
           <notify_url>http://www.zcqy520.com/openpayment/wxpay/wapnotify.php</notify_url>
           <out_trade_no>".$time."__".substr($token,0,10)."</out_trade_no>
           <spbill_create_ip>".$_SERVER['REMOTE_ADDR']."</spbill_create_ip>
           <total_fee>".$money."</total_fee>
           <trade_type>MWEB</trade_type>
           <sign>".$sign."</sign>
        </xml> ";

$posturl = "https://api.mch.weixin.qq.com/pay/unifiedorder";

$ch = curl_init($posturl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_POST, 1);  
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); 
$response = curl_exec($ch);  
curl_close($ch);

$xmlobj = json_decode(json_encode(simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA ))); 
exit($xmlobj->mweb_url);