<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>很抱歉，此页面暂时找不到！</title>
</head>
<body>
<div>
    {{--<h1>抱歉，找不到此页面~</h1>--}}
    <h1>{{$content or "抱歉，找不到此页面~"}}</h1>
    <h2>Sorry, the site now can not be accessed. </h2>
    <font color="#666666">你请求访问的页面，暂时找不到，我们建议你返回首页官网进行浏览，谢谢！</font><br /><br />
    <div class="button">
        <a style="display:block" href="/" title="进入官网" >进入官网</a>
        <a href="javascript:history.go(-1)" title="返回上一页" >返回上一页</a>
    </div>
</div>


</body>
</html>
