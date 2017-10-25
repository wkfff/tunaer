<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */
require_once("config.php");
require_once 'wappay/service/AlipayTradeService.php';
require_once "./../../openapi/DB.php" ;

$handle = DB::getInstance();

$arr=$_POST;
$alipaySevice = new AlipayTradeService($config); 
$alipaySevice->writeLog(var_export($_POST,true));
$result = $alipaySevice->check($arr);

/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
if($result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号

	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号

	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];


    if($_POST['trade_status'] == 'TRADE_FINISHED') {

		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
			//如果有做过处理，不执行商户的业务程序
				
		//注意：
		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		$tmp = explode("__", $out_trade_no);
		$money = $tmp[1];
		$uid = explode("_", $out_trade_no);
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
		$sql = " insert into mobile_charge (uid,money,chargefrom,orderid) values (".$uid.",'".$money."','alipay_pc','".$out_trade_no."') ";
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
    }
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
	echo "success";		//请不要修改或删除
		
}else {
    //验证失败
    echo "fail";	//请不要修改或删除

}

?>

