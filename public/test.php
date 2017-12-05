<?php

//echo "ok";die;
//bmtongzhi("18328402805",2,"11-12","118.00","西南财大旁","13408584356");

class test {
    public $num = "123";
    function __construct($num)
    {
        $this->num = $num;
        self::p();
    }
    public static function p() {
        echo "122222222222222";
    }
}
$t = new test(123);
//$t->p();

function bmtongzhi($mobile,$num,$date,$money,$addr,$phone) {
    require_once dirname(__FILE__).'/../app/Libs/aliyunsms/api_demo/SmsDemo.php';
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
    echo $response->Code;
    if( strtoupper($response->Code) == "OK" ) {
        return true;
    }else{
        return false;
    }
}

//九月   6










