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
    @if( $_SERVER['REMOTE_ADDR'] == '183.222.50.199' )
        <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" ></script>
        <script>
            alert('123');
            wx.config("{{getsignature()}}");
            wx.ready(function(){
            });
            wx.error(function(res){
            });
            wx.onMenuShareTimeline({
                title: document.title,
                link: location.href,
                imgUrl: 'http://www.cdtunaer.com/web/images/admin.png',
                success: function () { },
                cancel: function () { }
            });
            wx.onMenuShareAppMessage({
                title: document.title,
                link: location.href,
                desc: '徒哪儿户外俱乐部邀请大家参加徒步活动，健康徒步，有氧运动，让户外更加精彩。点击即可报名',
                imgUrl: 'http://www.cdtunaer.com/web/images/admin.png',
                type: '',
                dataUrl: '',
                success: function () { },
                cancel: function () { }
            });
        </script>
    @endif

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