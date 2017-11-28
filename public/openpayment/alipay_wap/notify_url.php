<?php
require_once "./config.php";
require_once './wappay/service/AlipayTradeService.php';
//require_once dirname(__FILE__) . "/../../../app/Libs/DB.php";
//$handle = DB::getInstance();
require_once dirname(__FILE__) . "/../donotify.php";
$arr=$_POST;

$alipaySevice = new AlipayTradeService($config);

$result = $alipaySevice->check($arr);

if($result) {//验证成功
    $tmp = explode("__", $_POST['out_trade_no']);
    $donotify = new Donotify("alipay_wap",$tmp[2],$_POST['total_amount'],$_POST['trade_no'],$tmp[1]);
//    $orderid = $_GET['trade_no'];
//    $money = $_GET['total_amount'];
//    $sql = " select * from payment where orderid='".$orderid."' ";
//    $res = $handle->select($sql);
//    if( count($res) > 0 ) {
//        echo "success";
//        return ;
//    }
//    //商户订单号
//    $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
//    $tmp = explode("__", $out_trade_no);
//    $order_id = $tmp[1];
//    $type = $tmp[2];
//
//
//    $sql = " insert into payment (paytype,money,orderid) values ('alipay_wap','".$money."','".$orderid."') ";
////    file_put_contents(dirname(__file__)."/log.php","#".$sql.'#',FILE_APPEND);
//    $handle->excute($sql);
//
//    if( $type == 'tubu' ) {
////        file_put_contents(dirname(__file__)."/log.php","#tubu#",FILE_APPEND);
//        $sql = " update tubuorder set orderid='".$orderid."' where id= ".$order_id;
////        file_put_contents(dirname(__file__)."/log.php","#".$sql."#",FILE_APPEND);
//        $res = $handle->excute($sql);
//    }else{
////        file_put_contents(dirname(__file__)."/log.php","#other#",FILE_APPEND);
//        $sql = " update shoporder set orderid='".$orderid."' where id= ".$order_id;
//        $res = $handle->excute($sql);
//    }
    echo "success";
}
else {
    //验证失败
    echo "fail";
}

?>

