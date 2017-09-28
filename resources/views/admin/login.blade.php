<!DOCTYPE html>
<html lang="en">
<head>

    <!-- start: Meta -->
    <meta charset="utf-8">
    <title>tunaer login</title>
    <meta name="description" content="Bootstrap Metro Dashboard">
    <meta name="author" content="Dennis Ji">
    <meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <!-- end: Meta -->

    <!-- start: Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- end: Mobile Specific -->

    <!-- start: CSS -->
    <link id="bootstrap-style" href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link id="base-style" href="/admin/css/style.css" rel="stylesheet">
    <link id="base-style-responsive" href="/admin/css/style-responsive.css" rel="stylesheet">
    {{--<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>--}}
    <!-- end: CSS -->


    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <!--<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>-->
    <link id="ie-style" href="/admin/css/ie.css" rel="stylesheet">
    <![endif]-->

    <!--[if IE 9]>
    <link id="ie9style" href="/admin/css/ie9.css" rel="stylesheet">
    <![endif]-->

    <!-- start: Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/web/images/ico.png">
    <!-- end: Favicon -->

    <style type="text/css">
        body { background: url(/admin/img/bg-login.jpg) !important; }
    </style>



</head>

<body>
<div class="container-fluid-full">
    <div class="row-fluid">

        <div class="row-fluid">
            <div class="login-box">
                <div class="icons">
                    <a href="/"><i class="halflings-icon home"></i></a>
                    <a href="javascript:void(0)"><i class="halflings-icon cog"></i></a>
                </div>
                <h2>管理员帐号登录</h2>
                <form class="form-horizontal" action="/admin/dologin" method="post">
                    <fieldset>

                        <div class="input-prepend" title="Username">
                            <span class="add-on"><i class="halflings-icon user"></i></span>
                            <input class="input-large span10" value="" name="uname" id="username" type="text" placeholder="用户名"/>
                        </div>
                        <div class="clearfix"></div>

                        <div class="input-prepend" title="Password">
                            <span class="add-on"><i class="halflings-icon lock"></i></span>
                            <input class="input-large span10" value="" name="passwd" id="password" type="password" placeholder="密码"/>
                        </div>
                        <div class="clearfix"></div>

                        <label class="remember" for="remember">忘记密码请联系主管理员</label>

                        <div class="button-login">
                            <button type="button" onclick="dologin()" class="btn btn-primary">登录</button>
                        </div>
                        <div class="clearfix"></div>
                    </fieldset>
                </form>

            </div><!--/span-->
        </div><!--/row-->


    </div><!--/.fluid-container-->

</div><!--/fluid-row-->

<script src="/admin/js/jquery-1.9.1.min.js"></script>
<script src="/admin/js/jquery-migrate-1.0.0.min.js"></script>

<script src="/admin/js/jquery-ui-1.10.0.custom.min.js"></script>

<script src="/admin/js/jquery.ui.touch-punch.js"></script>

<script src="/admin/js/modernizr.js"></script>

<script src="/admin/js/bootstrap.min.js"></script>

<script src="/admin/js/jquery.cookie.js"></script>

<script src='/admin/js/fullcalendar.min.js'></script>

<script src='/admin/js/jquery.dataTables.min.js'></script>

<script src="/admin/js/excanvas.js"></script>
<script src="/admin/js/jquery.flot.js"></script>
<script src="/admin/js/jquery.flot.pie.js"></script>
<script src="/admin/js/jquery.flot.stack.js"></script>
<script src="/admin/js/jquery.flot.resize.min.js"></script>

<script src="/admin/js/jquery.chosen.min.js"></script>

<script src="/admin/js/jquery.uniform.min.js"></script>

<script src="/admin/js/jquery.cleditor.min.js"></script>

<script src="/admin/js/jquery.noty.js"></script>

<script src="/admin/js/jquery.elfinder.min.js"></script>

<script src="/admin/js/jquery.raty.min.js"></script>

<script src="/admin/js/jquery.iphone.toggle.js"></script>

<script src="/admin/js/jquery.uploadify-3.1.min.js"></script>

<script src="/admin/js/jquery.gritter.min.js"></script>

<script src="/admin/js/jquery.imagesloaded.js"></script>

<script src="/admin/js/jquery.masonry.min.js"></script>

<script src="/admin/js/jquery.knob.modified.js"></script>

<script src="/admin/js/jquery.sparkline.min.js"></script>

<script src="/admin/js/counter.js"></script>

<script src="/admin/js/retina.js"></script>

<script src="/admin/js/custom.js"></script>
<script src="/web/js/common.js"></script>
<!-- end: JavaScript-->

</body>
</html>

<script>
    function dologin() {
        var uname = $("input[name=uname]").val();
        var passwd = $("input[name=passwd]").val();
        $.post("/admin/dologin",{
            "uname":uname,"passwd":passwd
        },function(d){
            if( ajaxdata(d) ) {
                location.href="/v6";
            }
        })
    }
</script>
