@extends('admin.common')

@section("content")
    <div id="content" class="span10">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="index.html">主面板</a>
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">次面板</a></li>
        </ul>

        <div class="row-fluid">
            <div class="span3 statbox purple" onTablet="span6" onDesktop="span3">
                <div style="font-size:16px;">活动报名列表</div>
                <div class="number" style="margin-top:40px;margin-right:50px;">854</div>
                <div class="title" style="margin-top:30px;">人次</div>
            </div>
            <div class="span3 statbox green" onTablet="span6" onDesktop="span3">
                <div style="font-size:16px;">活动报名列表</div>
                <div class="number" style="margin-top:40px;margin-right:50px;">854</div>
                <div class="title" style="margin-top:30px;">人次</div>
            </div>
            <div class="span3 statbox blue" onTablet="span6" onDesktop="span3">
                <div style="font-size:16px;">活动报名列表</div>
                <div class="number" style="margin-top:40px;margin-right:50px;">854</div>
                <div class="title" style="margin-top:30px;">人次</div>
            </div>
            <div class="span3 statbox yellow" onTablet="span6" onDesktop="span3">
                <div style="font-size:16px;">活动报名列表</div>
                <div class="number" style="margin-top:40px;margin-right:50px;">854</div>
                <div class="title" style="margin-top:30px;">人次</div>
            </div>

        </div>
        <div class="row-fluid">

            <a class="quick-button metro yellow span2">
                <i class="icon-group"></i>
                <p>Users</p>
                <span class="badge">237</span>
            </a>
            <a class="quick-button metro red span2">
                <i class="icon-comments-alt"></i>
                <p>Comments</p>
                <span class="badge">46</span>
            </a>
            <a class="quick-button metro blue span2">
                <i class="icon-shopping-cart"></i>
                <p>Orders</p>
                <span class="badge">13</span>
            </a>
            <a class="quick-button metro green span2">
                <i class="icon-barcode"></i>
                <p>Products</p>
            </a>
            <a class="quick-button metro pink span2">
                <i class="icon-envelope"></i>
                <p>Messages</p>
                <span class="badge">88</span>
            </a>
            <a class="quick-button metro black span2">
                <i class="icon-calendar"></i>
                <p>Calendar</p>
            </a>
            <div class="clearfix"></div>
        </div>
    </div>
@stop