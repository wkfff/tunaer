<?php

$postObj = simplexml_load_string(file_get_contents("php://input"), 'SimpleXMLElement', LIBXML_NOCDATA );
$arr = array();
foreach ($postObj as $key => $value) {
    $arr[$key] = $value;
} 
$status = $arr['result_code'];
require_once dirname(__FILE__) . "/../../../app/Libs/DB.php";
$handle = DB::getInstance();
file_put_contents(dirname(__file__)."/log.php","111111111111111",FILE_APPEND);
file_put_contents(dirname(__file__)."/log.php","****************************",FILE_APPEND);
file_put_contents(dirname(__file__)."/log.php",file_get_contents("php://input"),FILE_APPEND);
if(trim($status) == "SUCCESS") {

	$out_trade_no = $arr['transaction_id'];
    $money = $arr['total_fee']/100;
    $tmparr = explode("zxc", $arr['out_trade_no']);
    $order_id = $tmparr[1];
    $type = $tmparr[2];

    $sql = " insert into payment (paytype,money,orderid) values ('wx_saoma','".$money."','".$out_trade_no."') ";
    $handle->query($sql);

    if( $type == 'tubu' ) {
        $sql = " update tubuorder set orderid='".$out_trade_no."' where id= ".$order_id;
        $res = $handle->excute($sql);
    }else{
        $sql = " update shoporder set orderid='".$out_trade_no."' where id= ".$order_id;
        $res = $handle->excute($sql);
    }

    $xml = "
    <xml>
      <return_code><![CDATA[".$status."]]></return_code>
      <return_msg><![CDATA[OK]]></return_msg>
    </xml>";
    echo $xml;
		
}else {
    echo "fail";	//请不要修改或删除

}


