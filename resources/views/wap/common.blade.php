<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield("meta","")
    {{--<meta name="theme-color" content="#e83888">--}}
    <link rel="shortcut icon" type="image/x-icon" href="/web/images/ico.png">
    <link rel="stylesheet" href="/web/css/bootstrap.min.css">
    <link rel="stylesheet" href="/wap/css/common.css">

    @yield("css","")

    <title>@yield("title","测试")</title>
    <script src="/web/js/jquery.min.js" ></script>
    <script src="/web/js/bootstrap.min.js" ></script>
    <script src="/wap/js/common.js" ></script>

</head>
<body >
@yield("body","")

</body>

</html>
@yield("htmlend","")