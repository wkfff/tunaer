<?php

$postObj = simplexml_load_string(file_get_contents("php://input"), 'SimpleXMLElement', LIBXML_NOCDATA );
$arr = array();
foreach ($postObj as $key => $value) {
    $arr[$key] = $value;
} 
$status = $arr['result_code'];
// $xml = "
//         <xml>
//           <return_code><![CDATA[".$status."]]></return_code>
//           <return_msg><![CDATA[OK]]></return_msg>
//         </xml>";
// echo $xml;

require_once "./../../openapi/DB.php" ;

$handle = DB::getInstance();

if(trim($status) == "SUCCESS") {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$out_trade_no = $arr['transaction_id'];


		$money = $arr['total_fee']/100;

		$uid = explode("__", $arr['out_trade_no']);
		$uid = explode("_", $uid[1]);
		$uid = $uid[0];
		$day = 0;
		$viptype = 0;
		switch ($money) {
			case '59':
				$viptype = 1; $day = 30;
				break;
			case '198':
				$viptype = 2; $day = 180;
				break;
			case '399':
				$viptype = 3; $day = 365;
				break;
			case '0.01':
				$viptype = 3; $day = 365;
				break;
			default:
				return ;
		}

		// 检查重复
		$sql = " select * from mobile_charge where orderid='".$out_trade_no."' ";
		$check = $handle->query($sql);
		if( $check->num_rows ) {
			// echo "已经处理过了";
			$sql = " select * from mobile_vip where uid= ".$uid;
			$res = $handle->select($sql);
			echo "success";
			return ;
		}
		//插入充值记录
		$sql = " insert into mobile_charge (uid,money,chargefrom,orderid) values (".$uid.",'".$money."','wxpay_wap','".$out_trade_no."') ";
		$insertjilu = $handle->excute($sql,false,true);
		if( !$insertjilu ) {
			echo "success";
			return ;
		}
		//检查这个用户之前的vip到期没有
		$sql = " select * from mobile_vip where uid =  " . $uid;
		$res = $handle->select($sql);
		
	    if( count($res) ){
	    	// 以前开通过会员。但是现在已经过期了
	    	if( time() > strtotime($res[0]['endtime']) ) {
	    		$sql = " update mobile_vip set begintime='".date("Y-m-d H:i:s")."' , endtime='".date("Y-m-d H:i:s",strtotime("+".$day." day"))."',viptype=".$viptype." where uid= ".$uid;

	    		$r = $handle->excute($sql);
	    		
	    	}else{
				// 会员还没有过期 ，本次操作为续费:续费有一个地方需要注意
				// 如果之前用户开通的是普通会员，本次开通的是钻石会员，那么之前的普通会员时间直接清零
	    		if( $viptype != $res[0]['viptype'] ) {
	    			$endtime = date("Y-m-d H:i:s",strtotime("+".$day." day"));
	    		}else{
	    			$endtime = date("Y-m-d H:i:s",strtotime("+".$day." day",strtotime($res[0]['endtime'])));
	    		}
	    		$sql = " update mobile_vip set begintime='".date("Y-m-d H:i:s")."' , endtime='".$endtime."',viptype=".$viptype." where uid= ".$uid;
	    		$r = $handle->excute($sql);
	    	}
	    }else{
	    	// 以前没有开过会员
	    	$sql = " insert into mobile_vip (uid,endtime,viptype) values (".$uid.",'".date("Y-m-d H:i:s",strtotime("+".$day." day"))."',".$viptype.")";
			$r = $handle->excute($sql);
	    }
// file_put_contents(dirname(__file__)."/log.php","111");
		
}else {
    //验证失败
    echo "fail";	//请不要修改或删除

}