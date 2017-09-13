@extends("web.common")

@section("css")
<link rel="stylesheet" href="/web/css/index.css">
@stop

@section("body")
    @include("web.header")
    @include("web.banner")

    <!-- 最近活动 -->
    <div class="content">
        <div style="color:#2260b4;text-align:center;margin-top:40px;">
            <span class="sprite_l"></span>
            <span style="font-size:30px;vertical-align: middle;padding:0 10px">徒步活动</span>
            <span class="sprite_r"></span>
            <p style="height: 18px;line-height: 18px;color: #919191;margin:5px 0;">实时发布活动项目，简单方便集齐驴友！</p>
            <div class="huodongnav" style="margin:15px 0;">
                <?php
                //                    动态加载分类
                if( !Session::get('types') ) {
                    $types = DB::select(" select * from tubutypes ");
                    Session::put("types",$types);
                }
                $types = Session::get('types');
                ?>
                @for( $i=0;$i<count($types);$i++ )
                        <a href="/tubulist/{{$types[$i]->id}}"><span>{{$types[$i]->name}}</span></a>
                @endfor

            </div>
            <div class="pics">
                @for( $i=0;$i<count($tubus);$i++ )
                    <div onclick="location.href='/tubu/tubudetail/{{$tubus[$i]->id}}'" class="picitem" style="background-image:url(/admin/data/images/{{$tubus[$i]->pictures}})">
                        <div style="width:100%;height:100%;">
                            <a href="/tubu/tubudetail/{{$tubus[$i]->id}}"><div style="text-align: left;padding:0 10px;width:100%;">{{$tubus[$i]->title}}</div></a>
                        </div>
                    </div>

                @endfor

            </div>
            <div style="clear:both" ></div>
        </div>
        <a href="/member/list"><div style="background-size:cover;background-repeat:no-repeat;background-position:center;background-image:url(/web/images/youjipanl.jpg);height:106px;width:100%;margin:30px 0;"></div></a>
        <div style="color:#2260b4;text-align:center;margin-top:40px;">
            <span class="sprite_l"></span>
            <span style="font-size:30px;vertical-align: middle;padding:0 10px">徒友动态</span>
            <span class="sprite_r"></span>
            <p style="height: 18px;line-height: 18px;color: #919191;margin:5px 0;">交流分享，学习更多知识，结交更多朋友！</p>
            <div class="userlist" >
                @for( $i=0;$i<count($users);$i++ )
                    <a href="/user/{{$users[$i]->userid}}">
                        <div class="useritem" >
                            <div class="userhead" style="background-image:url(/head/{{$users[$i]->userid}});"></div>
                            <div class="userinfo" >
                                <div>{{$users[$i]->uname}}</div>
                                <div>{{$users[$i]->age}}岁 {{$users[$i]->mryst}}</div>
                                <div>{{$users[$i]->addr}}</div>
                            </div>
                        </div>
                    </a>
                @endfor
            </div>
            <div style="clear:both;height:20px;" ></div>
            <div style="margin:20px 0;" >
                <span class="sprite_l"></span>
                <span style="font-size:30px;vertical-align: middle;padding:0 10px">精彩回顾</span>
                <span class="sprite_r"></span>
                <p style="height: 18px;line-height: 18px;color: #919191;margin:5px 0;">交流分享，学习更多知识，结交更多朋友！</p>
            </div>
            <div class="pics">
                @for( $i=0;$i<count($youjis);$i++ )
                    <div onclick="location.href='/youji/detail/{{$youjis[$i]->id}}'" class="sjitem" style="margin-bottom:50px;background-image:url(/web/data/images/{{$youjis[$i]->pic}})">
                        <div style="width:100%;height:100%;">
                            <div style="position:absolute;bottom:0px;left:0px;height:40px;padding-right:20px;padding-top:7px;width:100%;color:#fff;background:rgba(0,0,0,0.5);text-align:right;">
                                <img src="/web/images/love.png" style="height:20px;" alt="">
                                <span style="margin-left:10px;">{{$youjis[$i]->zancnt}}</span>
                            </div>
                            <a href="/youji/detail/{{$youjis[$i]->id}}"><div>{{$youjis[$i]->title}}</div></a>
                        </div>
                    </div>
                @endfor

            </div>
            <div style="clear:both" ></div>
        </div>
        <a href="/youjilist/1"><div style="background-size:cover;background-repeat:no-repeat;background-position:center;background-image:url(/web/images/huiyuanpanl.jpg);height:106px;width:100%;margin:30px 0;margin-top:70px;"></div></a>
        <div style="color:#2260b4;text-align:center;margin-top:40px;">
            <span class="sprite_l"></span>
            <span style="font-size:30px;vertical-align: middle;padding:0 10px">徒步资讯</span>
            <span class="sprite_r"></span>
            <p style="height: 18px;line-height: 18px;color: #919191;margin:15px 0;">提供新闻线索，了解最新行业动态！</p>
            
            <div class="zixun">
                @for( $i=0;$i<count($zixuns);$i++ )
                    <div onclick="location.href='/zixun/detail/{{$zixuns[$i]->id}}'" class="zixunpic" style="background-image:url(/admin/data/images/{{$zixuns[$i]->pic}});margin-right:45px;">
                        <div class="zixuncon" >
                            <a href="/zixun/detail/{{$zixuns[$i]->id}}"><span>{{$zixuns[$i]->title}}</span></a>
                        </div>
                    </div>
                @endfor
            </div>
            <div style="clear:both;height:30px;" ></div>
        </div>
        <a href="/zixun"><div style="background-size:cover;background-repeat:no-repeat;background-position:center;background-image:url(/web/images/zixunpanl.jpg);height:106px;width:100%;"></div></a>
    </div>


    @include("web.footer")

@stop

@section("htmlend")
    <script type='text/javascript' src="/web/js/index.js" ></script>

@stop