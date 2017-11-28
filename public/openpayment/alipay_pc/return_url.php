<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>开通结果</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="charge/pay.css" media="all">
</head>
<body>
<br>
<?php
/* *
 * 功能：支付宝页面跳转同步通知页面
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 */
require_once("config.php");
require_once 'pagepay/service/AlipayTradeService.php';
require_once dirname(__FILE__) . "/../../../app/Libs/DB.php";
$handle = DB::getInstance();
// var_dump($handle);die;
// $cache = i_Memcached::getInstance();

$arr=$_GET;
// print_r($config);die;
$alipaySevice = new AlipayTradeService($config); 

$result = $alipaySevice->check($arr);



/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
if($result) {//验证成功
    $orderid = $_GET['trade_no'];
    $money = $_GET['total_amount'];
    $sql = " select * from payment where orderid='".$orderid."' ";
    $res = $handle->select($sql);
    if( count($res) > 0 ) {
        echo "订单已处理　";
        echo "<a href='/'>返回首页</a>";
        return ;
    }
    //商户订单号
    $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
    $tmp = explode("__", $out_trade_no);
    $order_id = $tmp[1];
    $type = $tmp[2];


    $sql = " insert into payment (paytype,money,orderid) values ('alipay_pc','".$money."','".$orderid."') ";
//    file_put_contents(dirname(__file__)."/log.php","#".$sql.'#',FILE_APPEND);
    $handle->excute($sql);

    if( $type == 'tubu' ) {
//        file_put_contents(dirname(__file__)."/log.php","#tubu#",FILE_APPEND);
        $sql = " update tubuorder set orderid='".$orderid."' where id= ".$order_id;
//        file_put_contents(dirname(__file__)."/log.php","#".$sql."#",FILE_APPEND);
        $res = $handle->excute($sql);
    }else{
//        file_put_contents(dirname(__file__)."/log.php","#other#",FILE_APPEND);
        $sql = " update shoporder set orderid='".$orderid."' where id= ".$order_id;
        $res = $handle->excute($sql);
    }
    echo "订单已处理.　";
    echo "<a href='/'>返回首页</a>";
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "支付异常，请联系客服　";
    echo "<a href='/'>返回首页</a>";
}
?>
</body>
</html>