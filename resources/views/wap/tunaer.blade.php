


<!DOCTYPE html>

<html>
<head><title>
        诚邀您参加徒步活动
    </title><meta name="description" content="欢迎加入徒哪儿户外俱乐部" /><meta name="keywords" content="徒哪儿,户外" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="apple-mobile-web-app-capable" content="yes" /><meta name="apple-mobile-web-app-status-bar-style" content="black" /><meta content="telephone=no" name="format-detection" /><meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <!--库-->
    <script type="text/javascript" src="/wap/tuiguang/jquery.min.js"></script>
    <script type="text/javascript" src="/wap/tuiguang/amazeui.js"></script>
    <link href="/wap/tuiguang/css.css?ty=3" rel="stylesheet" />
    </head>
<body>
@if( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
    {{--@if( 1==1 )--}}
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" ></script>
    <script>
        // alert('13')
        wx.config({!! getsignature() !!});
        wx.ready(function(res){
            alert(res);
        });
        wx.error(function(res){
            alert(res);
        });
        wx.onMenuShareTimeline({
            title: "345678",
            link: location.href,
            imgUrl: 'http://www.cdtunaer.com/web/images/admin.png',
            success: function () { },
            cancel: function () {
                alert('quxiao');
            }
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
<div class="maindiv">
    <header>
        <div class="logo">
            <a href="/">
                <img src="/wap/spread/welcome_1.png?ty=2" />
            </a>
        </div>
        <p>欢迎加入徒哪儿户外俱乐部</p>
        <div id="slogan">
            <img src="/wap/tuiguang/welcome_2.png?ty=2" />
        </div>
    </header>
    <!-----------轮播banner----------->
    <div id="index_banner" style="margin:0 10px;">
        <div class="am-slider am-slider-default" >
            <ul class="am-slides" >
                @for( $i=0;$i<count($list);$i++ )
                <li>
                    <a href="/tubu/tubudetail/{{$list[$i]->id}}"><div style="position:relative; background-image:url(/admin/data/images/{{$list[$i]->pictures}});height:270px;width:100%;background-size:cover;border-radius:2px;overflow: hidden">
                        <div style="background-color:rgba(200,200,200,0.8);color:#333;position: absolute;bottom:0px;left:0px;padding:10px;">{{$list[$i]->title}}</div>
                    </div></a>
                </li>
                @endfor
            </ul>
        </div>
    </div>
    <div class="btn"><a href="/register" id="Areg_X">立即注册会员</a></div>
    <div class="btn divWX" onclick="img2big($('#wxpic')[0])"><a href="javascript:void(0)">关注徒哪儿微信公众号</a></div>
    <img src="/web/kindeditor/attached/image/20171101/20171101164558_62102.jpg" id="wxpic" style="display: none">
    <section id="about">
        <h1>关于徒哪儿户外俱乐部</h1>
        <p>
            徒哪儿是一个依托专注、理想、绿色、自然的运动理念，打造专注于绿色健身、有氧运动、娱乐康养领域的户外交友平台，力图为广大徒步爱好者建立一个聚集共同爱好共同信念的交流圈层，让徒友的生活更加丰富多彩。
        </p>
    </section>
    <section id="show">
        <h1>徒步展示</h1>
        <div id="pictures">
            <div class="img">
                <img src="/wap/tuiguang/welcome_4.jpg?ty=2">
            </div>
        </div>
    </section>
    <footer>
        <div class="logo">
            <img src="/wap/spread/welcome_3.png?ty=2">
        </div>
    </footer>
</div>
<script src="/wap/js/common.js" ></script>
<script>
    $(document).ready(function(){
        localStorage.setItem("spreadid","{{$spreadid}}#{{time()+3600}}");
    });
    $(function () {
        $('.am-slider').flexslider({
            controlNav: true,               // Boolean: 是否创建控制点
            directionNav: false,             // Boolean: 是否创建上/下一个按钮（previous/next）
            touch: true,                    // Boolean: 允许触摸屏触摸滑动滑块
        });
    });
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == "micromessenger") {
        //微信
        $(".divWX").show();
    } else {
        $(".divWX").hide();
    }
</script>
</body>
</html>
