<div style="height:55px;" ></div>
<div class="container-fluid" style="position:fixed;bottom:0px;left:0px;z-index:999;width:100%;height:55px;background:#fff;padding:0px;">
    <style>
        .footnav{
            width:19%;height:60px;float:left;text-align:center;color:#444;
        }
    </style>
    <a href="/"><div class="footnav">
        <img src="/web/images/icon-footer1-a.png" style="height:22px;margin-top:5px;margin-bottom:5px;">
        <span style="display:block;font-size:14px;">主页</span>
    </div></a>
    <a href="/tubulist"><div class="footnav">
        <img src="/web/images/icon-footer2-a.png" style="height:22px;margin-top:5px;margin-bottom:5px;">
        <span style="display:block;font-size:14px;">徒步活动</span>
        </div></a>

    @if( Session::get('uid') )
        <a href="/chatlist"><div class="footnav" style="width:24%;">
                <img src="/web/images/love-message.png" style="height:50px;margin-top:5px;margin-bottom:5px;">
            </div></a>
    @else
        <a href="javascript:openlogion()" ><div class="footnav" style="width:24%;">
                <img src="/web/images/love-message.png" style="height:50px;margin-top:5px;margin-bottom:5px;">
            </div></a>

    @endif

    <a href="/shops"><div class="footnav">
        <img src="/web/images/icon-footer4-a.png" style="height:22px;margin-top:5px;margin-bottom:5px;">
        <span style="display:block;font-size:14px;">徒步商城</span>
        </div></a>

    @if( Session::get('uid') )
    <a href="/user/{{Session::get('uid')}}"><div class="footnav">
        <img src="/web/images/icon-footer5-a.png" style="height:22px;margin-top:5px;margin-bottom:5px;">
        <span style="display:block;font-size:14px;">我的</span>
    </div></a>
    @else
    <a href="javascript:openlogion()" ><div class="footnav">
        <img src="/web/images/icon-footer5-a.png" style="height:22px;margin-top:5px;margin-bottom:5px;">
        <span style="display:block;font-size:14px;">登录</span>
    </div></a>

    @endif

</div>
