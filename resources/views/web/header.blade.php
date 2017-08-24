@include("web.login")
@include("web.register")

<div class="top1">
    <div class="topcontent">
        <div>
            你好,欢迎访问 徒那儿
        </div>
        <div>
            <a href="#">个人中心</a>
            <a href="#">收藏本站</a>
            <a href="#">注册</a>
            <a href="#">登录</a>
            <span>028-61667788</span>
        </div>
    </div>
</div>
<div class="top2">
    <div class="topcontent">
        <div>
            你好,欢迎访问 徒那儿
        </div>
        <div>
            <a href="#">个人中心</a>
            <a href="#">收藏本站</a>
            <a href="#">注册</a>
            <a href="#">登录</a>
            <span>028-61667788</span>
        </div>
    </div>
</div>

<style>
    .top1{
        height:35px;line-height:35px;width:100%;background:#ECECEC;
    }
    .topcontent{
        width:1200px;margin:0 auto;
    }
    .topcontent div:nth-child(1) {
        float:left;
    }
    .topcontent div:nth-child(2) {
        float:right;
    }
    .top2{
        height:80px;
    }
</style>