<?php

$p = addslashes($_POST['price'])*100;   //充值金额
$u = addslashes($_POST['uid']);   //充值的用户（网站会员id）

$tmpArr = array(
    'appid'=>'wx31ffe118466ac333',   //不要填成了 公众号原始id
    'mch_id'=>'1464027602',
    'nonce_str'=>'vgvdfvfg54325rf',
    'time_stamp'=>time(),
    'product_id'=>$p."s".$u,   
    );

ksort($tmpArr);  //根据键值排序数组

$buff = "";
foreach ($tmpArr as $k => $v)
{
   $buff .= $k . "=" . $v . "&";
}
$buff = trim($buff, "&");

$stringSignTemp=$buff."&key=51b3363e91fe317fc346526f5933f15e";
$sign= strtoupper(MD5($stringSignTemp));


$reurl = "weixin://wxpay/bizpayurl?sign=".$sign."&appid=wx31ffe118466ac333&mch_id=1464027602&product_id=".$tmpArr['product_id']."&time_stamp=".$tmpArr['time_stamp']."&nonce_str=".$tmpArr['nonce_str'];

// 官方文档中介绍了有个长url转短url的API 写的还是很清楚的 没遇到坑
$posarr = array(
    'appid'=>'wx31ffe118466ac333',
    'mch_id'=>'1464027602',
    'nonce_str'=>'vgvdfvfg54325rf',
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

$stringSignTemp=$buff."&key=51b3363e91fe317fc346526f5933f15e";
$sign= strtoupper(MD5($stringSignTemp));

// 官方文档中说了 所有传输必须采用xml格式  post方式 https协议

$xml = "<xml>
           <appid>wx31ffe118466ac333</appid>
           <mch_id>1464027602</mch_id>
           <nonce_str>vgvdfvfg54325rf</nonce_str>
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