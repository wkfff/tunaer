<?php

$postObj = simplexml_load_string(file_get_contents("php://input"), 'SimpleXMLElement', LIBXML_NOCDATA );
$arr = array();
foreach ($postObj as $key => $value) {
    $arr[$key] = $value;
}
$status = $arr['result_code'];
require_once dirname(__FILE__) . "/../../../app/Libs/DB.php";
$handle = DB::getInstance();
$xml = "
    <xml>
      <return_code><![CDATA[".$status."]]></return_code>
      <return_msg><![CDATA[OK]]></return_msg>
    </xml>";
if(trim($status) == "SUCCESS") {
    $out_trade_no = $arr['transaction_id'];

    $sql = " select * from payment where orderid='".$out_trade_no."' ";
    $res = $handle->select($sql);
    if( count($res) > 0 ) {
        echo $xml;
        return ;
    }

    $out_trade_no = $arr['transaction_id'];
    $money = $arr['total_fee']/100;
    $tmparr = explode("__", $arr['out_trade_no']);
    $order_id = $tmparr[1];
    $type = $tmparr[2];

    $sql = " insert into payment (paytype,money,orderid) values ('wx_wap','".$money."','".$out_trade_no."') ";
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
//    file_put_contents(dirname(__file__)."/log.php","#over#",FILE_APPEND);

    echo $xml;
//    file_put_contents(dirname(__file__)."/log.php","#end#",FILE_APPEND);
}else {
    echo "fail";	//请不要修改或删除

}


