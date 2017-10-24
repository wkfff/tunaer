@extends("wap.common")
{{--@section("title","徒友动态")--}}
@section("css")
    <style>
        .type{
            height:100px;border-radius:3px;width:99%;margin:0 auto;margin-top:5px;
        }
        .tubuitem{
            width:99%;height:200px;background-size:cover;margin:0 auto;
            background-position:center;
            background-repeat:no-repeat;margin-top:7.5px;
            /*display: inline-block;*/
            position: relative;
        }
        .type a{
            color:#fff;
        }
        .newitem{
            height:105px;width:100%;position: relative;padding:10px;padding-left:150px;
            border-bottom:1px solid #ddd;
        }
        .img{
            width:130px;height:80px;top:10px;left:10px;background-image:url(/web/images/p1.jpg);
            position: absolute;background-size:cover;
        }
        .title{
            height:40px;overflow: hidden;line-height:20px;color:#333;
        }
        .price{
            color:orange;bottom:10px;right:10px;
            position: absolute;
        }

    </style>
@stop

@section("body")
    @include("wap.header")
    @include("wap.banner")
    <div class="content">
        <div class="type" style="background:#FF697A;text-align:center;color:#fff;" >
            <a href="/tubulist"><div style="height:100px;width:33%;display:inline-block;float:left;border-right:1px solid #fff;" >
                <span style="font-size:14px;margin-top:10px;margin-bottom:10px;display:block;" >活动</span>
                <img src="/web/images/hiking.png" style="height:40px;" >
            </div></a>
            <div style="height:100px;width:33%;display:inline-block;float:left;border-right:1px solid #fff;" >
                <a href="/tubulist/3"><span style="font-size:14px;display:block;height:49px;line-height:49px;border-bottom:1px solid #fff;" >周边游</span></a>
                <a href="/tubulist/4"><span style="font-size:14px;display:block;height:50px;line-height:50px;" >长途徒步</span></a>

            </div>
            <div style="height:100px;width:33%;display:inline-block;float:left;" >
                <a href="/tubulist/7"><span style="font-size:14px;display:block;height:49px;line-height:49px;border-bottom:1px solid #fff;" >团队徒步</span></a>
                <a href="/tubulist/6"><span style="font-size:14px;display:block;height:50px;line-height:50px;" >自驾游</span></a>
            </div>
        </div>
        <div class="type" style="background:#3D98FF;text-align:center;color:#fff;" >
            <a href="/member/list"><div style="height:100px;width:33%;display:inline-block;float:left;border-right:1px solid #fff;" >
                <span style="font-size:14px;margin-top:10px;margin-bottom:10px;display:block;" >交友</span>
                <img src="/web/images/men-shaking-hands.png" style="height:40px;" >
            </div></a>
            <div style="height:100px;width:33%;display:inline-block;float:left;border-right:1px solid #fff;" >
                <a href="/member/dongtai"><span style="font-size:14px;display:block;height:49px;line-height:49px;border-bottom:1px solid #fff;" >徒友动态</span></a>
                <a href="/member/list"> <span style="font-size:14px;display:block;height:50px;line-height:50px;" >徒友交流</span></a>

            </div>
            <div style="height:100px;width:33%;display:inline-block;float:left;" >
                <a href="/tubulist/5"><span style="font-size:14px;display:block;height:49px;line-height:49px;border-bottom:1px solid #fff;" >交友活动</span></a>
                <a href="/youjilist/1"><span style="font-size:14px;display:block;height:50px;line-height:50px;" >徒友游记</span></a>
            </div>
        </div>
        <div class="type" style="background:#44C522;text-align:center;color:#fff;" >
            <a href="/single/2"><div style="height:100px;width:33%;display:inline-block;float:left;border-right:1px solid #fff;" >
                <span style="font-size:14px;margin-top:10px;margin-bottom:10px;display:block;" >徒哪儿</span>
                <img src="/web/images/sailboat.png" style="height:40px;" >
                </div></a>
            <div style="height:100px;width:33%;display:inline-block;float:left;border-right:1px solid #fff;" >
                <a href="/tubulist/8"><span style="font-size:14px;display:block;height:49px;line-height:49px;border-bottom:1px solid #fff;" >国内旅游</span></a>
                <a href="/zixun"><span style="font-size:14px;display:block;height:50px;line-height:50px;" >徒步资讯</span></a>

            </div>
            <div style="height:100px;width:33%;display:inline-block;float:left;" >
                <a href="/dasai"><span style="font-size:14px;display:block;height:49px;line-height:49px;border-bottom:1px solid #fff;" >摄影大赛</span></a>
                <a href="/shops"><span style="font-size:14px;display:block;height:50px;line-height:50px;" >徒步商城</span></a>
            </div>
        </div>
        <p style="vertical-align: middle;height:40px;line-height:40px;padding:0px;text-align:center;margin:0px;margin-top:10px;">
            <img src="/web/images/index_icon05.png" style="max-height:30px;margin:0px;vertical-align: middle;" >
            <span style="font-size:18px;color:#666;">徒步活动</span>
        </p>
        <div class="tublist">


        </div>
        <div style="color:dodgerblue;height:30px;width:100%;line-height:30px;text-align:center;cursor: pointer;" >
            <a href="javascript:void(0)" onclick="recenttubu()" style="color:#666;font-size:16px;">更多活动
                <span class="glyphicon glyphicon-menu-right" ></span>
            </a>
        </div>

    </div>

    @include("wap.footer")

@stop

@section("htmlend")
    <script>
        $(document).ready(function(){
            recenttubu();
        })
        function recenttubu() {
            if( window.tubupage ) {
                window.tubupage++;
            }else{
                window.tubupage = 1;
            }
            $.post("/recenttubu",{"page":window.tubupage},function(d){
                if( res = ajaxdata(d) ) {
                    if( res.length == 0 && window.tubupage!=1 ) {
                        toast("没有更多了"); return ;
                    }
                    for( var i=0;i<res.length;i++ ) {
                        var item = `<a href="/tubu/tubudetail/${res[i].id}"><div class="newitem" >
                            <div class="img" style="background-image:url(/admin/data/images/${res[i].pictures})"></div>
                            <p class="title">${res[i].title}</p>
                            <span style="display:block;font-size:10px;color:#888;">出发时间：${res[i].startday}</span>
                            <span style="display:block;font-size:10px;color:#888">活动地点：${res[i].mudidi}</span>
                            <span class="price" >￥${res[i].price}</span>
                        </div></a>`;
                        $(".tublist").append(item);
                    }
                }
            })
        }
    </script>

@stop