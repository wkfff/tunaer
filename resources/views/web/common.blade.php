<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield("meta","")
    
    <link rel="shortcut icon" type="image/x-icon" href="/web/images/ico.png">
    <link rel="stylesheet" href="/web/css/bootstrap.min.css">
    <link rel="stylesheet" href="/web/css/common.css">

    @yield("css","")

    <title>@yield("title","成都徒步网")</title>
    <script src="/web/js/jquery.min.js" ></script>
    <script src="/web/js/bootstrap.min.js" ></script>
    <script src="/web/js/common.js" ></script>
    <script>
        if( location.host == "cdtunaer.com" ) {
            location.href = location.href.replace("cdtunaer.com","www.cdtunaer.com");
        }
    </script>
</head>
<body >

    @yield("body","")
    <div class="suspend">
        <dl>
            <dt class="IE6PNG"></dt>
            <dd class="suspendQQ" onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=3090434371&o=徒哪儿&q=7', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');"  border="0" SRC=http://wpa.qq.com/pa?p=1:3090434371:1 alt="点击这里给我发消息"></dd>
            <dd class="suspendTel"><a href="javascript:void(0);"></a></dd>
        </dl>
    </div>
</body>
<!-- 代码 开始 -->
<div id="top"></div>
<!-- 代码 结束 -->

</html>
<script src="/web/js/common.js" ></script>
@yield("htmlend","")