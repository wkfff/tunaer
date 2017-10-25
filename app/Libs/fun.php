<?php

use Illuminate\Contracts\View\Factory as ViewFactory;

function checknull(...$args)
{
    foreach( $args as $arg ){
        if( !$arg || trim($arg) == '' ) {
            return false;
        }
    }
    return true;
}

function login($phone,$passwd,$returnuid=false) {
    $sql = " select user.*,userattr.uname from user left join userattr on user.id=userattr.uid where phone=? and passwd=?  ";
    $res = DB::select($sql,[$phone,md5($passwd)]);
    if( count($res) >= 1 ) {
        if( $res[0]->status == 0 ) {
            echo "400-账户不可用"; return;
        }
        if( !$res[0]->uname ) {
            $res[0]->uname = '请完善资料';
        }
        Session::put('uid', $res[0]->id);
        Session::put('uname', $res[0]->uname);
        if(!$returnuid) {
//            返回一个包含用户登录信息的加密字符串　有效期10天
            echo "200-".jiami($res[0]->id);
        }
    }else{
        if(!$returnuid) {
            echo "400-用户名或密码错误";
        }
    }
}

function fenye($count,$url,$currentpage=1,$page=10,$search='?') {
    if( $count <= $page ) {
        return '';
    }
    $pagecnt = ceil($count/$page);
    $html = "";
//    小于５页直接输出
    if( $pagecnt <=5 ) {
        for( $i=0;$i<$pagecnt;$i++ ) {
            if( $i == $currentpage-1 ) {
                $html .= "<a class='fenyecurrent' href='javascript:void(0)'>".($i+1)."</a>";
            }else{
                $html .= "<a href='".$url.$search."page=".($i+1)."'>".($i+1)."</a>";
            }

        }
    }else{
//        大于５页
        list($start,$end) = qujian($currentpage,$pagecnt);
//        上一页
        $html .= "<a href='".$url.$search."page=".($currentpage-1>=1?$currentpage-1:1)."'>上一页</a>";
//        下一页
        $html .= "<a href='".$url.$search."page=".($currentpage+1>=$pagecnt?$pagecnt:$currentpage+1)."'>下一页</a>";
//        首页
        $html .= "<a href='".$url.$search."page=1'>首页</a>";
//        倒退５页
        $html .= "<a href='".$url.$search."page=".($currentpage-5>=1?$currentpage-5:1)."'><<</a>";
        for( $i=$start;$i<$end;$i++ ) {
            if( $i == $currentpage-1 ) {
                $html .= "<a class='fenyecurrent' href='javascript:void(0)'>".($i+1)."</a>";
            }else{
                $html .= "<a href='".$url.$search."page=".($i+1)."'>".($i+1)."</a>";
            }
        }
        //        前进５页
        $html .= "<a href='".$url.$search."page=".($currentpage+5>=$pagecnt?$pagecnt:$currentpage+5)."'>>></a>";
        //        末页
        $html .= "<a href='".$url.$search."page=".$pagecnt."'>末页</a>";
    }
    return "<div class='fenye' >".$html."</div>";
}

function qujian($current,$pagecnt) {

    $start = $current;
    $end = $current;
    for( $i=$current;$i<$pagecnt;$i++ ) {
        if( $end%5 == 0 ) {
            break;
        }
        $end++;
    }

    for( $i=$current;$i>=1;$i-- ) {
        $start--;
        if( $start%5 == 0 ) {
            break;
        }
    }
    return array($start,$end);
}

function isMobile() {
    $agent = isset($_SERVER["HTTP_USER_AGENT"])?$_SERVER["HTTP_USER_AGENT"]:"Unknow";
    $agents = array("Android", "iPhone","SymbianOS", "Windows Phone","iPad", "iPod","Unknow");
    for ($i=0; $i < count($agents); $i++) {
        if( stripos($agent, $agents[$i])  ){
            return true;
        }
    }
    return false;
}

//覆盖框架的　view方法
function view($view = null, $data = [], $mergeData = [])
{
    if( strtoupper($_SERVER['REQUEST_METHOD'])=="GET" && isMobile() ) {
        $view = str_replace("web.","wap.",$view);
    }
    $factory = app(ViewFactory::class);

    if (func_num_args() === 0) {
        return $factory;
    }

    return $factory->make($view, $data, $mergeData);
}


//function myview($view = null, $data = [], $mergeData = []) {
//    $factory = app(ViewFactory::class);
//
//    if (func_num_args() === 0) {
//        return $factory;
//    }
//
//    return $factory->make($view, $data, $mergeData);
//}
//自定义加密
/**
 * @param $str　待加密字符串
 * 返回：　随机字符串+[分割符 ascii(n)]+[原串ascii+n]
 */
//ord()　字符串－＞ascii
//chr() ascii－＞字符串
function jiami($str) {
    $rand = str_shuffle("!@#$%^&*()AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz1234567890");
    $rarr = str_split($rand);
//    把字符串转换为数组
    $sarr = str_split($str);
//    随机长度
    $need = rand(30, 50) - count($sarr);
    $res = "";
    for( $i=0;$i<$need;$i++ ) {
        $res .= $rarr[$i];
    }
//    原串在ascii上的增量
    $ascii_add = rand(3,8);
    $res .= "!x0" . ord($ascii_add) . "$1r";
    for( $j=0;$j<count($sarr);$j++ ) {
        $res .= chr( ord($sarr[$j]) + $ascii_add );
    }
    return base64_encode($res);
}
function jiemi($str) {
    $str = base64_decode($str);
    preg_match_all("/!x0(\d+)\\$1r(.*)$/",$str,$matches);
    $fg = explode($matches[1][0]."$1r",$str);
    $sarr = str_split($fg[1]);
    $res = "";
    for( $i=0;$i<count($sarr);$i++ ) {
        $res .= chr( ord($sarr[$i]) - chr($matches[1][0]) );
    }
    return $res;
}

/**
 * @param $orderid  订单号
 * @param $money    付款金额
 * @param $type     订单类型　tubu shop
 * @return mixed
 */
function wxpay_saoma($orderid,$money,$type) {
//    $money = $money*100;
//    $appid = "wx10106332de6f9840";
//    $mch_id = "1490663772";
//    $key = "53972fb92388341e4ae2249f7a17c348";
//    $nonce_str = "rtyguhjikdfghjvascv345r23";

 $p = 1;
 $u = "18884";

    $tmpArr = array(
        'appid'=>'wx10106332de6f9840',   //不要填成了 公众号原始id
        'mch_id'=>'1490663772',
        'nonce_str'=>'vgvdfvfg54325rf',
        'time_stamp'=>time(),
        'product_id'=>$p."s".$u,
    );
// 生成签名需要上面五个参数，文档上没有，不要问我是怎么知道的，我只知道二维码格式是这样的：
// weixin：//wxpay/bizpayurl?sign=XXXXX&appid=XXXXX&mch_id=XXXXX&
// product_id=XXXXXX&time_stamp=XXXXXX&nonce_str=XXXXX
// 还有就是看一下他的sdk也能看到他是怎么生成签名的，用了那些参数。
// 有好几个坑我都是通过看sdk明白的，所以你有必要看一下他的sdk

// 注意：上面五个参数是固定的  这个地方不可以自己加额外参数 否则报 原生url参数错误
// 但是如果不传参数我的业务逻辑怎么做呢  我这里用了一个比较巧妙的方法，没错，我们可以在产品编号product_id上
// 做文章，看我这里产品编号是 价格+当前网站用户userid组成的字符串，用
// 字符s分割，方便后面我们拆开，文档中说明了在用户扫描后只会返回openid和
// product_id给回调地址，再次证明你即便在上面新增额外参数也没有任何意义。我们完全可以
// 把需要的参数组装成字符串，然后用product_id来传递

    ksort($tmpArr);  //根据键值排序数组
// 把数组转换成这种格式：appid=wxd930ea5d5a258f4f&body=test&device_info=1000&mch_id=10000100&nonce_str=ibuaiVcKdpRxkhJA
    $buff = "";
    foreach ($tmpArr as $k => $v)
    {
        $buff .= $k . "=" . $v . "&";
    }
    $buff = trim($buff, "&");
// 这个地方有的人可能会想到 http_build_query 函数直接了当，干净利索
// 我刚开始就是用的这个函数，坑了老半天。。。 意外发现生成的字符串里面居然有几个字节的乱码
// 乍一看完全和上面生成的一样，各位可以尝试一下
// 这些步骤官方文档还是有的  不多说
    $stringSignTemp=$buff."&key=53972fb92388341e4ae2249f7a17c348";
    $sign= strtoupper(MD5($stringSignTemp));

// 生成的二维码url  到这里就可以返回给前台 前端使用 jquery.qrcode.min.js 这个库可以生成二维码了
// 我试了一下  url太长 生成的二维码太复杂  像素差的手机就悲哀了，接着往下看
// $reurl = "weixin://wxpay/bizpayurl?appid=wxf51780c84b0e0aa2&mch_id=1448961302&nonce_str=".$tmpArr['nonce_str']."&product_id=".$tmpArr['product_id']."&time_stamp=".$tmpArr['time_stamp']."&sign=".$sign;
    $reurl = "weixin://wxpay/bizpayurl?sign=".$sign."&appid=wx31ffe118466ac333&mch_id=1464027602&product_id=".$tmpArr['product_id']."&time_stamp=".$tmpArr['time_stamp']."&nonce_str=".$tmpArr['nonce_str'];

// 官方文档中介绍了有个长url转短url的API 写的还是很清楚的 没遇到坑
    $posarr = array(
        'appid'=>'wx10106332de6f9840',
        'mch_id'=>'1490663772',
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

    $stringSignTemp=$buff."&key=53972fb92388341e4ae2249f7a17c348";
    $sign= strtoupper(MD5($stringSignTemp));

// 官方文档中说了 所有传输必须采用xml格式  post方式 https协议

    $xml = "<xml>
           <appid>wx10106332de6f9840</appid>
           <mch_id>1490663772</mch_id>
           <nonce_str>vgvdfvfg54325rf</nonce_str>
           <sign>".$sign."</sign>
           <long_url>".$posarr['long_url']."</long_url>
        </xml>";
//    echo $xml;die;

// 短连接请求地址
    $posturl = "https://api.mch.weixin.qq.com/tools/shorturl";
//下面使用curl来请求
    $ch = curl_init($posturl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //返回文件流
    curl_setopt($ch, CURLOPT_POST, 1);  //使用post提交
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);   //post数据
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;die;
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

}
















