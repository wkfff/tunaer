<?php
if( empty(Session::get("footer")) ) {
    $sql = " select * from options where title='footer' ";
    $footer = DB::select($sql);
    Session::put("footer",$footer[0]->content);
}
$footer = Session::get("footer");

?>
{!! $footer !!}
{{--<div class="footer" >--}}
    {{--<div style="width:1200px;margin:0 auto;position: relative;">--}}
        {{--<div class="foot1"></div>--}}
        {{--<div class="foot2">--}}
            {{--<div class="item">--}}
                {{--<div class="title">关于我们</div>--}}
                {{--<a href="#" >广告与合作</a>--}}
                {{--<a href="#" >联系我们</a>--}}
                {{--<a href="#" >加入我们</a>--}}
                {{--<a href="#" >关于我们</a>--}}
            {{--</div>--}}
            {{--<div class="item">--}}
                {{--<div class="title">帮助中心</div>--}}
                {{--<a href="#" >会员指南</a>--}}
                {{--<a href="#" >付款指南</a>--}}
                {{--<a href="#" >报名流程</a>--}}
                {{--<a href="#" >新手入门</a>--}}
            {{--</div>--}}
            {{--<div class="item">--}}
                {{--<div class="title">实用工具</div>--}}
                {{--<a href="#" >申请领队</a>--}}
                {{--<a href="#" >网站地图</a>--}}
            {{--</div>--}}
            {{--<div class="item">--}}
                {{--<div class="title">关注我们</div>--}}
                {{--<img src="/web/images/weixin.png" style="width:100px;" alt="">--}}
            {{--</div>--}}
            {{--<div class="item">--}}
                {{--<div class="title">友情链接</div>--}}
                {{--<a href="#" >成都徒步网</a>--}}
                {{--<a href="#" >世纪佳缘</a>--}}
            {{--</div>--}}
            {{--<div class="item">--}}
                {{--<div class="title">手机APP下载</div>--}}
                {{--<img src="/web/images/weixin.png" style="width:100px;" alt="">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div style="clear:both;height:20px;" ></div>--}}
        {{--<div class="foot3">--}}
                {{--<p class="copyright">版权所有：国际市民体育联盟中国总部 &nbsp; 北京每日东方徒步运动中心&nbsp;&nbsp; www.chinawalking.net.cn &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel：010-84896319/20 &nbsp; &nbsp; &nbsp; &nbsp;友情链接申请QQ号：94419616 &nbsp; &nbsp; &nbsp; &nbsp;ICP备05067361</p>--}}
        {{--</div>--}}


    {{--</div>--}}
{{--</div>--}}

{{--<style>--}}
    {{--.item{--}}
        {{--height:150px;float:left;border-left: 1px solid #fefdfd;padding:0px 50px;--}}
    {{--}--}}
    {{--.item>.title {--}}
        {{--font-size: 18px;margin-bottom:10px;--}}
    {{--}--}}
    {{--.item a{--}}
        {{--display:block;line-height:25px;font-size: 13px;color:#fefdfd;--}}
        {{--cursor: pointer;--}}
    {{--}--}}
    {{--.footer{--}}
        {{--width: 100%;--}}
        {{--height: 241px;--}}
        {{--padding-top: 30px;--}}
        {{--background: url(/web/images/foot_bg.jpg) no-repeat;--}}
        {{--margin-top: 100px;--}}
        {{--color: #fefdfd;--}}
        {{--margin-bottom:-20px;--}}

    {{--}--}}
    {{--.foot1{--}}
        {{--width: 170px;--}}
        {{--height: 33px;--}}
        {{--background: url(/web/images/foot_bg1.png) no-repeat;--}}
        {{--position: absolute;--}}
        {{--top: -63px;--}}
        {{--left: 0;--}}

    {{--}--}}
{{--</style>--}}