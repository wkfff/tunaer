<?php

/**
 * 统一处理订单 徒步和商城
 */

require_once dirname(__FILE__) . "/../../app/Libs/DB.php";
require_once dirname(__FILE__).'/../../app/Libs/aliyunsms/api_demo/SmsDemo.php';

class Donotify {
    /**
     * Donotify constructor.
     * @param $paytype 交易类型 支付宝或者微信
     * @param $type 订单类型 徒步或者商城
     * @param $money 交易金额
     * @param $trade_id 交易号 支付宝或者微信的订单号
     * @param $order_id 订单表的id
     */
    function __construct($paytype,$type,$money,$trade_id,$order_id){
        $this->paytype = $paytype;
        $this->type = $type;
        $this->money = $money;
        $this->trade_id = $trade_id;
        $this->order_id = $order_id;
        /*初始化数据库*/
        $this->db = DB::getInstance();
        /*开始执行*/
        $this->handle();
    }

    private function handle() {
        /*检查订单是否已经处理过了*/
        if( $this->isdealed() ) {
            return false;
        }
        /*写入订单数据*/
        $sql = " insert into payment (paytype,money,orderid) values 
                ('".$this->paytype."','" . $this->money . "','" . $this->trade_id . "') ";
        $this->db->excute($sql);
        /*更新订单数据*/
        if( $this->type == 'tubu' ) {
            $sql = " update tubuorder set orderid='".$this->trade_id."' where id= ".$this->order_id;
            $this->db->excute($sql);
            /*查询数据*/
            $sql = " select tubuorder.*,tubuhuodong.startday,tubuhuodong.phone from 
                    tubuorder inner join tubuhuodong on tubuhuodong.id=tubuorder.tid where 
                    tubuorder.id= ".$this->order_id . " limit 1 ";
            $res = $this->db->select($sql);
            /*发送通知短信*/
            $this->bmtongzhi($res[0]['mobile'],$res[0]['num'],substr($res[0]['startday'],5),$this->money,
                $res[0]['jihe'],$res[0]['phone']);
        }else{
            $sql = " update shoporder set orderid='".$this->trade_id."' where id= ".$this->order_id;
            $this->db->excute($sql);
        }

    }
    private function isdealed() {
        $sql = " select * from payment where orderid='" . $this->trade_id . "' ";
        $res = $this->db->select($sql);
        if (count($res) > 0) {
            $data = "success";
            /*如果不是支付宝 就返回 xml数据*/
            if( !in_array($this->paytype,array('alipay_wap','alipay_pc')) ) {
                $data = "<xml>
                          <return_code><![CDATA[SUCCESS]]></return_code>
                          <return_msg><![CDATA[OK]]></return_msg>
                        </xml>";
            }
            echo $data; return true;
        } return false;
    }
    private function bmtongzhi($mobile,$num,$date,$money,$addr,$phone) {
        $demo = new \SmsDemo(
            "LTAICyYaKmLyh9sj",
            "fh7VDi4xBUIQPY4H13eAfVx88kfwaP"
        );
        $response = $demo->sendSms(
            "徒哪儿", // 短信签名
            "SMS_113461578", // 短信模板编号
            $mobile, // 短信接收者
            Array(  // 短信模板中字段的值
                "num"=>$num,
                "date"=>$date,
                "money"=>$money,
                "addr"=>$addr,
                "phone"=>$phone,
            ),"0"
        );
        if( strtoupper($response->Code) == "OK" ) {
            return true;
        }else{
            return false;
        }
    }

}
