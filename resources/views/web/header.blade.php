

    


<div class="top1">
    <div class="content">
        <div style="color: #727272;font-size: 12px;float:left;height:35px;overflow:hidden;">
            <span>您好，欢迎访问成都徒哪儿</span><a href="javascript:void(0)" onclick="toast('app即将上线，敬请期待．')" style="color: #194C8E;font-weight: bold;font-size: 16px;line-height:35px;margin-left:10px;">下载客户端</a>
        </div>
        <div class="top1right" style="float:right">
            {{--  <a href="#">个人中心{{Session::get('uid')}}</a>  --}}
            <a href="#">收藏本站</a>
            @if( Session::get('uid') )
                <a href="/user/{{Session::get('uid')}}" style="color:#194C8E;font-size:14px;">{{Session::get('uname')}}</a> | <a style="color:#194C8E;font-size:14px;" href="javascript:void(0)" onclick="localStorage.removeItem('login_token');location.href='/outlogin';">退出</a>
            @else
                <script>
                    if( localStorage.getItem("login_token") ) {
                        var token = localStorage.getItem("login_token");
                        $.post("/tokenlogin",{"token":token},function(d){
                            if( ajaxdata(d) ) {
                                location.reload();
                            }else{
                                localStorage.removeItem("login_token");
                            }
                        })
                    }
                </script>
                <a href="javascript:openreg()" style="margin-right:0px;font-size:14px;color:#194C8E">注册</a>
                <span>|</span>
                <a href="javascript:openlogion()" style="font-size:14px;color:#194C8E">登录</a>
            @endif
            
            <a href="#" >联系管理员：13540139792</a>
        </div>
    </div>
</div>
<div class="top2">
    <div class="content">
        <a href="/"><img src="/web/images/newlogo.png" style="float:left;height:70px;margin-top:10px;" alt=""></a>
        {{--<div style="margin-left:20px;float:left;margin-top:10px;">--}}
            {{--<img src="/web/images/top_pic1.png" alt="">--}}
            {{--<img src="/web/images/top_pic2.png" alt="">--}}
            {{--<img src="/web/images/top_pic3.gif" alt="">--}}
        {{--</div>--}}
        <div class="searchbox" >
            <form action="/searchtubu" method="GET">
            <input placeholder="搜索目的地／活动" type="text" name="key" style="height:25px;width:240px;border:none;background:none;margin-top:10px;margin-left:20px;font-size:16px;border-right:1px solid rgba(25,76,142,0.6);padding-right:10px;" >
            <input class="searchbtn" value="搜索"  type="submit">
            </form>
        </div>
    </div>
</div>
<div class="top3">
    <div class="content nav">
        <a href="/" >首页</a>
        <a href="javascript:void(0)" class="nav_a_hover navlist" >
            <span>徒步活动</span><i></i>
            <div class="xiala">
                <?php
//                    动态加载分类
                    if( !Session::get('types') ) {
                        $types = DB::select(" select * from tubutypes ");
                        Session::put("types",$types);
                    }
                    $types = Session::get('types');
                ?>
                @for( $i=0;$i<count($types);$i++ )
                    @if( $types[$i]->name != '国内旅游' && $types[$i]->name != "交友活动" )
                        <div onclick="location.href='/tubulist/{{$types[$i]->id}}'">{{$types[$i]->name}}</div>
                    @else
                        @if($types[$i]->name == "国内旅游")
                                <span style="display:none" >{{ $guoneilvyou = $types[$i]->id }}</span>
                            @else
                                <span style="display:none" >{{ $jiaoyouhuodong = $types[$i]->id }}</span>
                            @endif

                    @endif
                @endfor
            </div>
        </a>
        <a href="javascript:void(0)" class="navlist" >
            <span>徒步交友</span><i></i>
            <div class="xiala">
                <div onclick="location.href='/member/dongtai'">徒友动态</div>
                <div onclick="location.href='/tubulist/{{$jiaoyouhuodong}}'">交友活动</div>
                <div onclick="location.href='/member/list'">徒友交流</div>
            </div>
        </a>
        <a href="/tubulist/{{$guoneilvyou}}" >国内旅游</a>


        <a href="/zixun" >
            <span>徒步资讯</span>
        </a>
        <a href="javascript:void(0)" class="navlist" >
            <span>徒步足迹</span><i></i>
            <div class="xiala">
                <div onclick="location.href='/youjilist/2'">官方游记</div>
                <div onclick="location.href='/youjilist/1'">会员游记</div>
            </div>
        </a>

        <a href="/shops" >徒步商城</a>
        <a href="/dasai" class="nav_a_hover" >摄影大赛</a>
    </div>
</div>

<style>
    .xiala{
        position: absolute;left:0px;top:45px;width:120px;
        z-index:10;font-size: 15px;color:#333;display: none;border:1px solid #eee;
    }
    .xiala div{
        height:45px;line-height:45px;background:rgba(255,255,255,0.8);
        
    }
    .xiala div:hover{
        background: rgba(51,102,204,1);color:#fff;
    }
    .top1{
        height:35px;line-height:35px;width:100%;background:#ECECEC;
    }

    .top2{
        height:80px;
    }
    .top3{
        height:45px;background: url(/web/images/top_bg.jpg) no-repeat center top;
    }
    .top1right a{
        color:#666;font-size: 12px;margin-right:5px;
    }
    .nav a{
        line-height:45px;font-size:18px;text-decoration:none;color:#222;
        display:block;width:120px;text-align:center;float:left;position: relative;
    }
    .nav a:hover{
        background:rgba(51,102,204,1);color:#fff;
    }
    .nav_a_hover{
        background:#FF9900;
    }
    .nav a i{
        width: 12px;height: 10px;line-height: 70px;display: inline-block;
        margin-left: 5px;background: url(/web/images/rect.png) no-repeat 0 0;
    }
    .searchbox{
        height:45px;width:370px;border:1px solid #194C8E;float:right;margin-top:12.5px;
        border-radius:25px;position: relative;margin-left:400px;
    }
    .searchbtn{
        float: right; border:none; margin-top: 5px; width: 91px; font-size: 18px;
        color: #194C8E;height: 38px;cursor: pointer; 
        background: url(/web/images/zoom2.jpg) no-repeat left center;
        background-size: auto auto; background-size: 25px;
    }
</style>

<script>
    $(".navlist").on("mouseover",function(event){

        $(this).children(".xiala").toggle();
    })
    $(".navlist").on("mouseout",function(event){

        $(this).children(".xiala").toggle();
    })
</script>