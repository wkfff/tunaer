<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017052607354652",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALz4bl3QMGobNSI8B+jtrLVclYqOkF4pxlKBp032nqsLi/KrWUCv4dtXAKrVw4fOJ8pqhjI0SH/vQwgIID4kFDWZlgL07v4YwF5+dGheNAasdOploB0MEhbXbxqwOZfTRGV7gQY9AZEHAe/6aIN/9i1/w9yLXTImhtRLmKG83vlXAgMBAAECgYEAqCHJ4MJJMT7/6XPL/dzqG3tCukLaBE3a3LHq750L01e0rrbx9HII3CTuvRDwpbYxBRH+UFDgaKOy2kSQm3lyWC7SLKS+205I340xUVdCiwB/sP4kK48mY1dAJ2Ie2cRlyL4EW+UwRAicucs7/O3+TWQbkhEoZLXLUoC7P0+QfxECQQDgqWdXF9UnAUACBfenCZF3/8Vtnk7St+SRWLg9HCDq12FDUS15vBkSUQ5IJOsv6vdgozOrwN6N9fyi8SDcJmkzAkEA11SAwKPxMODxYSnlaqkXXsk9LYLh7An048pMIwaVJJxE2tE+jNShvTYgVDTlOzXul7MGDPOx1EGsut3SBCtXTQJAdhr4lcOUreWtVaL3d5vDGreefassuwArq/FdIdsovuytWCtT4dxtvcBY5rpp3Y4DsIz7e/5vwWehAbQL11BmGwJBAI8OYQua315t02+N+hDGjfQ3FiHqVlYOt1euyq5qbSOJfmUxprDBg0LFduz6x2BzEDRQh7CLJpWxnCP5wtFqSfECQHMUMvpm48ttED/WaqWimLC5ObSVKoHIo/0kMok8i74TEQKLqhLMNuzzAXhRrhqvZe0Zzq/XRnnzgRwNjT2GHaY=",
		
		//异步通知地址
		'notify_url' => "http://zcqy520.com/openpayment/alipay_pc/notify_url.php",
		
		//同步跳转
		'return_url' => "http://zcqy520.com/openpayment/alipay_pc/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB",
		
	
);