<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>tunaer后台管理系统</title>
    <meta name="description" content="Bootstrap Metro Dashboard">
    <meta name="author" content="Dennis Ji">
    <meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="bootstrap-style" href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link id="base-style" href="/admin/css/style.css" rel="stylesheet">
    <link id="base-style-responsive" href="/admin/css/style-responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link id="ie-style" href="/admin/css/ie.css" rel="stylesheet">
    <![endif]-->
    <!--[if IE 9]>
    <link id="ie9style" href="/admin/css/ie9.css" rel="stylesheet">
    <![endif]-->
    <!-- start: Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/web/images/ico.png">
    <!-- end: Favicon -->
</head>
<body>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand"  href="index.html"><span>tunaer</span></a>

            <div class="nav-no-collapse header-nav">
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="halflings-icon white user"></i>
                                {{Session::get('aname')}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu-title">
                                <span>帐号设置</span>
                            </li>
                            <li><a href="javascript(0)"><i class="halflings-icon user"></i>修改密码</a></li>
                            <li><a href="/admin/login"><i class="halflings-icon off"></i> 退出登录</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid-full">
    <div class="row-fluid">

        <!-- start: Main Menu -->
        <div id="sidebar-left" class="span2">
            <div class="nav-collapse sidebar-nav">
                <ul class="nav nav-tabs nav-stacked main-menu">
                    <li><a href="index.html"><i class="icon-bar-chart"></i><span class="hidden-tablet"> 主面板</span></a></li>
                    <li><a href="messages.html"><i class="icon-envelope"></i><span class="hidden-tablet"> 会员列表</span></a></li>
                    <li>
                        <a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i>
                            <span class="hidden-tablet"> 徒步活动</span></a>
                        <ul>
                            <li><a class="submenu" href="submenu.html"><i class="icon-file-alt"></i>
                                    <span class="hidden-tablet"> 发布活动</span></a></li>
                            <li><a class="submenu" href="submenu2.html"><i class="icon-file-alt"></i>
                                    <span class="hidden-tablet"> 活动列表</span></a></li>
                            <li><a class="submenu" href="submenu2.html"><i class="icon-file-alt"></i>
                                    <span class="hidden-tablet"> 徒步订单</span></a></li>
                        </ul>
                    </li>
                    <li><a href="ui.html"><i class="icon-eye-open"></i><span class="hidden-tablet"> 聊天列表</span></a></li>
                    <li><a href="widgets.html"><i class="icon-dashboard"></i><span class="hidden-tablet"> 用户动态</span></a></li>
                    <li>
                        <a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i>
                            <span class="hidden-tablet"> 徒步商城</span></a>
                        <ul>
                            <li><a class="submenu" href="submenu.html"><i class="icon-file-alt"></i>
                                    <span class="hidden-tablet"> 产品列表</span></a></li>
                            <li><a class="submenu" href="submenu2.html"><i class="icon-file-alt"></i>
                                    <span class="hidden-tablet"> 订单列表</span></a></li>
                            <li><a class="submenu" href="submenu3.html"><i class="icon-file-alt"></i>
                                    <span class="hidden-tablet"> 商品评论</span></a></li>
                        </ul>
                    </li>
                    <li><a href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> 徒步游记</span></a></li>
                    <li><a href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> 管理员列表</span></a></li>
                    <li><a href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> 运营管理</span></a></li>

                </ul>
            </div>
        </div>

        @yield("content")


    </div>
</div>

<footer>
    <p>
        <span style="text-align:left;float:left">&copy; 2018
            <a href="javascript:void(0)" alt="Bootstrap_Metro_Dashboard">成都徒步网</a></span>
    </p>
</footer>
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

</body>
</html>