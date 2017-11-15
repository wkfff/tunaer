<?php

$appid = "wx10106332de6f9840";
$mch_id = "1490663772";
$key = "4954bacf787c59654e7b8571831a5d38";
$nonce_str = "rtyguhjikdfghjvascv345r23";
$time_stamp = time();

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
    $sql = " select shoporder.*,product.price from shoporder inner join product on shoporder.shopid=product.id where shoporder.id= ".$order_id;
    $res = $handle->select($sql);
    if( count($res) == 1 ) {
        $money = $res[0]['price']*$res[0]['num'];
    }else{
        echo "400-支付异常";die;
    }
}

$tmpArr = array(
    'appid'=>$appid,   //不要填成了 公众号原始id
    'mch_id'=>$mch_id,
    'nonce_str'=>$nonce_str,
    'time_stamp'=>$time_stamp,
    'product_id'=>$order_id."#".$type."#".$money,
    );

ksort($tmpArr);  //根据键值排序数组

$buff = "";
foreach ($tmpArr as $k => $v)
{
   $buff .= $k . "=" . $v . "&";
}
$buff = trim($buff, "&");

$stringSignTemp=$buff."&key=".$key;
$sign= strtoupper(MD5($stringSignTemp));

$reurl = "weixin://wxpay/bizpayurl?sign=".$sign."&appid=".$appid."&mch_id=".$mch_id."&product_id=".$tmpArr['product_id']."&time_stamp=".$time_stamp."&nonce_str=".$nonce_str;

// 官方文档中介绍了有个长url转短url的API 写的还是很清楚的 没遇到坑
$posarr = array(
    'appid'=>$appid,
    'mch_id'=>$mch_id,
    'nonce_str'=>$nonce_str,
    'long_url'=>urlencode($reurl),
    // 这个地方文档中也说了 长url地址需要urlencode一下，不然你很可能得到签名错误
    );
ksort($posarr);
$buff = "";
foreach ($posarr as $k => $v)
{
   $buff .= $k . "=" . $v . "&";
}
$buff = trim($buff, "&");

$stringSignTemp=$buff."&key=".$key;
$sign= strtoupper(MD5($stringSignTemp));

// 官方文档中说了 所有传输必须采用xml格式  post方式 https协议

$xml = "<xml>
           <appid>".$appid."</appid>
           <mch_id>".$mch_id."</mch_id>
           <nonce_str>".$nonce_str."</nonce_str>
           <sign>".$sign."</sign>
           <long_url>".$posarr['long_url']."</long_url>
        </xml>";

// 短连接请求地址
$posturl = "https://api.mch.weixin.qq.com/tools/shorturl";
//下面使用curl来请求
$ch = curl_init($posturl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //返回文件流
curl_setopt($ch, CURLOPT_POST, 1);  //使用post提交
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);   //post数据
$response = curl_exec($ch);  
curl_close($ch);

// simplexml_load_string php内置的解析简单xml文件的扩展
$xmlobj = simplexml_load_string ($response, 'SimpleXMLElement', LIBXML_NOCDATA ); 
// 这个地方我直接输出 $xml->short_url 居然是空的  非要经过下面几步才得行  难道是我php版本低了
$arr = array();
foreach ($xmlobj as $key => $value) {
    // file_put_contents("mylog.php", $value."\n",FILE_APPEND);  
    $arr[$key] = $value;
} 
//这个链接就很短了  生成的二维码很简单  像素超低的手机都可以扫
echo $arr['short_url'];

// 最后，扫码支付只需要设置回调地址 ，至于支付授权目录 测试目录 白名单那些 都不用设置