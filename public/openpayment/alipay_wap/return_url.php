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

require_once "./config.php";
require_once './wappay/service/AlipayTradeService.php';
require_once dirname(__FILE__) . "/../../../app/Libs/DB.php";
$handle = DB::getInstance();

$arr=$_GET;

$alipaySevice = new AlipayTradeService($config); 

$result = $alipaySevice->check($arr);

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


    $sql = " insert into payment (paytype,money,orderid) values ('alipay_wap','".$money."','".$orderid."') ";
//    file_put_contents(dirname(__file__)."/log.php","#".$sql.'#',FILE_APPEND);
    $handle->excute($sql);

    if( $type == 'tubu' ) {
//        file_put_contents(dirname(__file__)."/log.php","#tubu#",FILE_APPEND);
        $sql = " update tubuorder set orderid='".$out_trade_no."' where id= ".$order_id;
//        file_put_contents(dirname(__file__)."/log.php","#".$sql."#",FILE_APPEND);
        $res = $handle->excute($sql);
    }else{
//        file_put_contents(dirname(__file__)."/log.php","#other#",FILE_APPEND);
        $sql = " update shoporder set orderid='".$out_trade_no."' where id= ".$order_id;
        $res = $handle->excute($sql);
    }
    echo "订单已处理.　";
    echo "<a href='/'>返回首页</a>";
}
else {
    //验证失败
    echo "开通失败，请联系客服.";
}

?>

</body>
</html>
