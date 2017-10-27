<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2088821550096237",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIICXAIBAAKBgQDStcwlW8THTRtNYvjsjciOCancp+HQjBdsri2EXJoDEV0HXwpcwDgRNKQ5h15RkRYMePoQP9XDnunwxvB9WV5iVxSYohjO79SdGmuJWRSoRiZCDAZgFopkInO9tSEfTqgMaIp3ltQH0FtoLCCDwIj2wKdU147zG/2jpyB7kB0+SwIDAQABAoGAeLSqUNBkRqO2OzuyS5jhRfTlOMF3i8dk995DtupxU8aTm1BnmECJHdohJc+VSXaqwdRftAVNiLW1YDgmtjgG55W7Q95Z7Qp0Em7XgV9qazsp0Nne8XyOCsItyDDRjRU61FV8K+t0x0ItuOkyG3PS7THlWzSi+muv1s09f+uq13ECQQD+Jb7rb9Gbbe2d3aUGr1pQAHc+laDIOXSBrRGMGClme6LDHUDfRdaLEFnL5fyLgGM1BLCydW2rBPjxmR8UWGVzAkEA1D7+vhLXulzRw/YvSDB3utSErDvplFJYbObCbTKt0BAJHc9XTM021cxf/4DOO5V13vwzAbOpMd4zFeQCAoZNyQJAYKhAZVCAuoljbr/mTJWSVozmzSGhJaVcXxlQbCSgUj7BV02f54qrHvaYAEk29GNe18Ix5Z1tmTZp65Dd1iIMawJBAMr+VPXFX75F9/nMAvywHlL53so7ovLQrvG44ks+JS7Rp2ZzX7N8se1ZQpdDwfsKv2k9HCuMgU3IjmNpZuKzQMECQAIG5O4KFsQOuOx0DNpZrWofnepEfhxTn58DivXiEVL+LuqUgr7zcL46EoPwIfJsY56ux7/H9f5Ov7QdKdXkBEU=",
		
		//异步通知地址
		'notify_url' => "http://cdtunaer.com/openpayment/alipay_wap/notify_url.php",
		
		//同步跳转
		'return_url' => "http://cdtunaer.com/openpayment/alipay_wap/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB",
		
	
);