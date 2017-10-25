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
require_once "./../../openapi/DB.php" ;
// 实例化数据库句柄
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
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	$out_trade_no = htmlspecialchars($_GET['out_trade_no']);
	$tmp = explode("__", $out_trade_no);
	$money = $tmp[1];
	$uid = explode("_", $out_trade_no);
	$uid = $uid[0];
	// echo $uid;
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
	// echo $sql; die;
	$check = $handle->query($sql);
	// echo "<pre>";
	// print_r($check);
	// var_dump($check->num_rows);
	if( $check->num_rows ) {
		// echo "已经处理过了";
		$sql = " select * from mobile_vip where uid= ".$uid;
		$res = $handle->select($sql);
		// var_dump($res[0]);die;
		echo "开通成功．到期时间:"  . $res[0]['endtime'];
		echo "<br>";
		echo "<h1><a href='/' style='color:#ff536a;'>返回情缘首页</a></h1>";
		return ;
	}
	// die;
	//插入充值记录
	$sql = " insert into mobile_charge (uid,money,chargefrom,orderid) values (".$uid.",'".$money."','alipay_pc','".$out_trade_no."') ";
	$insertjilu = $handle->excute($sql,false,true);
	if( !$insertjilu ) {
		echo "开通失败,请联系客服-"; 
		echo "<br>";
		echo "<h1><a href='/' style='color:#ff536a;'>返回情缘首页</a></h1>";
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
    		if( $r != 1 ) {
    			echo "开通失败,请联系客服";
    		}else{
    			echo "开通成功．到期时间:"  . date("Y-m-d H:i:s",strtotime("+".$day." day"));
    		}
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
    		if( $r != 1 ) {
    			echo "开通失败,请联系客服";
    		}else{
    			echo "开通成功．到期时间:"  . $endtime;
    		}

    	}
    }else{
    	// 以前没有开过会员
    	$sql = " insert into mobile_vip (uid,endtime,viptype) values (".$uid.",'".date("Y-m-d H:i:s",strtotime("+".$day." day"))."',".$viptype.")";
    	// exit($sql);
		$r = $handle->excute($sql);
		if( $r != 1 ) {
			echo "开通失败,请联系客服";
		}else{
			echo "开通成功．到期时间:"  . date("Y-m-d H:i:s",strtotime("+".$day." day"));
		}
		
    }


	//支付宝交易号

	// $trade_no = htmlspecialchars($_GET['trade_no']);
		
	// echo "验证成功<br />外部订单号：".$out_trade_no;

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "开通失败，请联系客服";
}
?>


<h1><a href="/" style="color:#ff536a;">返回情缘首页</a></h1>
</body>
</html>