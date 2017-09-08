<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>@yield("title","tunaer后台管理系统")</title>
    <meta name="description" content="Bootstrap Metro Dashboard">
    <meta name="author" content="Dennis Ji">
    <meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="bootstrap-style" href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link id="base-style" href="/admin/css/style.css" rel="stylesheet">
    <link id="base-style-responsive" href="/admin/css/style-responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <!--<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>-->
    {{--<link id="ie-style" href="/admin/css/ie.css" rel="stylesheet">--}}
    <![endif]-->
    <!--[if IE 9]>
    <!--<link id="ie9style" href="/admin/css/ie9.css" rel="stylesheet">-->
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
            <a class="brand"  href="/admin/index"><span>tunaer</span></a>

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
        <div id="sidebar-left" class="span2" style="overflow-y: auto;">
            <div class="nav-collapse sidebar-nav">
                <ul class="nav nav-tabs nav-stacked main-menu">
                    <li><a href="/admin/index"><i class="icon-bar-chart"></i><span class="hidden-tablet"> 主面板</span></a></li>
                    <li><a href="/admin/userlist"><i class="icon-envelope"></i><span class="hidden-tablet"> 会员列表</span></a></li>
                    <li>
                        <a class="dropmenu" style="cursor:pointer;"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> 徒步活动</span><i class="icon-angle-down"></i></a>
                        <ul>
                            <li><a class="submenu" href="/admin/tubulist"><i class="icon-file-alt"></i><span class="hidden-tablet">徒步列表</span></a></li>
                            <li><a class="submenu" href="/admin/fabutubu"><i class="icon-file-alt"></i><span class="hidden-tablet">发布徒步活动</span></a></li>
                            <li><a class="submenu" href="/admin/tubuorder"><i class="icon-file-alt"></i><span class="hidden-tablet">徒步订单</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="dropmenu" style="cursor:pointer;"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> 摄影大赛</span><i class="icon-angle-down"></i></a>
                        <ul>
                            <li><a class="submenu" href="/admin/fabudasai"><i class="icon-file-alt"></i><span class="hidden-tablet">创建比赛</span></a></li>
                            <li><a class="submenu" href="/admin/dasailist"><i class="icon-file-alt"></i><span class="hidden-tablet">大赛列表</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="dropmenu" style="cursor:pointer;"><i class="icon-folder-close-alt"></i><span class="hidden-tablet">徒步游记</span><i class="icon-angle-down"></i></a>
                        <ul>
                            <li><a class="submenu" href="/admin/fabuyouji"><i class="icon-file-alt"></i><span class="hidden-tablet">发布游记</span></a></li>
                            <li><a class="submenu" href="/admin/youjilist/2"><i class="icon-file-alt"></i><span class="hidden-tablet">官方游记</span></a></li>
                            <li><a class="submenu" href="/admin/youjilist/1"><i class="icon-file-alt"></i><span class="hidden-tablet">会员游记</span></a></li>
                        </ul>
                    </li>
                    {{--<li><a href="/admin/index"><i class="icon-edit"></i><span class="hidden-tablet"> 徒步游记</span></a></li>--}}
                    {{--<li><a href="ui.html"><i class="icon-eye-open"></i><span class="hidden-tablet"> 聊天列表</span></a></li>--}}
                    {{--<li><a href="widgets.html"><i class="icon-dashboard"></i><span class="hidden-tablet"> 用户动态</span></a></li>--}}
                    <li>
                        <a class="dropmenu" style="cursor:pointer;"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> 徒步商城</span><i class="icon-angle-down"></i></a>
                        <ul>
                            <li><a class="submenu" href="/admin/productlist"><i class="icon-file-alt"></i><span class="hidden-tablet">产品列表</span></a></li>
                            <li><a class="submenu" href="/admin/fabuproduct"><i class="icon-file-alt"></i><span class="hidden-tablet">发布商品</span></a></li>
                            <li><a class="submenu" href="/admin/productorder"><i class="icon-file-alt"></i><span class="hidden-tablet">订单列表</span></a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="dropmenu" style="cursor:pointer;"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> 行业资讯</span><i class="icon-angle-down"></i></a>
                        <ul>
                            <li><a class="submenu" href="/admin/zixunlist"><i class="icon-file-alt"></i><span class="hidden-tablet">资讯列表</span></a></li>
                            <li><a class="submenu" href="/admin/fabuzixun"><i class="icon-file-alt"></i><span class="hidden-tablet">发布资讯</span></a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="dropmenu" style="cursor:pointer;"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> 网站设置</span><i class="icon-angle-down"></i></a>
                        <ul>
                            <li><a class="submenu" href="/admin/setting/tubutypes"><i class="icon-file-alt"></i><span class="hidden-tablet">徒步分类</span></a></li>
                            <li><a class="submenu" href="/admin/setting/banner"><i class="icon-file-alt"></i><span class="hidden-tablet">Banner</span></a></li>
                            <li><a class="submenu" href="/admin/adminlist"><i class="icon-file-alt"></i><span class="hidden-tablet">管理员列表</span></a></li>
                        </ul>
                    </li>



                </ul>
            </div>
        </div>
        <div id="content" class="span10" style="min-height: 92vh;">
            @yield("content")
        </div>

    </div>
</div>

<footer>
    <p>
        <span style="text-align:left;float:left">&copy; 2018
            <a href="javascript:void(0)" alt="Bootstrap_Metro_Dashboard">成都徒步网</a></span>
    </p>
</footer>
<script src="/admin/js/jquery-1.10.min.js"></script>
<script src="/admin/js/bootstrap.min.js"></script>
<script src="/admin/js/common.js"></script>
</body>
</html>
@yield("htmlend","")
<script>
    $('.dropmenu').click(function(e){

        e.preventDefault();

        $(this).parent().find('ul').slideToggle();

    });
</script>