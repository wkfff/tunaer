@extends("web.common")

@section("css")
    <link rel="stylesheet" href="/web/css/index.css">
@stop

@section("body")
    @include("web.header")
    <style>
        .toppic{
            width:100%;height:335px;background-size:cover;background-position:center;background-repeat: no-repeat;
            position: relative;
        }
        .left{
            width:895px;float:left;
        }
        .right{
            width:300px;float:right;
        }
        .tubuitem{
            width:860px;height:230px;margin-bottom:20px;
            position: relative;border:1px solid #ccc;color:#919191;
        }
        .tubuitem:hover{
            border:1px solid dodgerblue;
        }
        .head{
            background-size:cover;background-position: center;;
            background-repeat:no-repeat;
        }
        .tubunav{
            height:45px;width:860px;border-bottom:1px solid #3366cc;color:#3366cc;margin-bottom:20px;
        }
        .tubunav a{
            display: block;float:left;width:100px;background:#4b8ee8;margin-right:10px;color:#fff;
            cursor: pointer;height:45px;line-height:45px;
            text-align: center;font-size:18px;
            text-decoration: none;
        }
        .tubunav a:hover{
            opacity:0.8;
        }
    </style>
    <div class="toppic" style="background-image: url(/admin/data/images/{{ count($list) == 0 ? '#' : $list[0]->pics}});" >
        @if(count($list) == 0)
            <div class='content'>
                <p style="font-size:20px;color:#999;margin-top:20px" >没有相关活动</p>
            </div>
        @endif
    </div>
    <div class="content">
        <div class="pics" ></div>
        <div style="font-size: 18px;color: #999;margin:30px 0">
            <a style="color: #999;" href="/">首页</a>
            <span>></span>
            <a style="color: #999;" href="javascript:void(0)" onclick="location.reload();" >{{$list[0]->name }}</a>
        </div>
        <div class="tubunav" >
            <?php
            //                    动态加载分类
            if( !Session::get('types') ) {
                $types = DB::select(" select * from tubutypes ");
                Session::put("types",$types);
            }
            $types = Session::get('types');
            ?>
            @for( $i=0;$i<count($types);$i++ )
                    <a href="/tubulist/{{$types[$i]->id}}">{{$types[$i]->name}}</a>
            @endfor
            <div style="float:right" >当前分类有 <span style="color:#ff536a" >{{$cnt}}</span> 个活动</div>
        </div>
            <div class="left">
                @for( $i=0;$i<count($list);$i++ )
                <div class="tubuitem">
                    <a href="/tubu/tubudetail/{{$list[$i]->id}}"><div class="head" style="cursor:pointer;margin:10px;width:200px;height:200px;float:left;background-image:url(/admin/data/images/{{$list[$i]->pictures}})" ></div></a>
                    <div style="margin:10px;width:600px;height:200px;float:left" >
                        <a href="/tubu/tubudetail/{{$list[$i]->id}}" style="color:#4b8ee8;font-size:20px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;max-width:500px;display:block;margin-bottom:30px;">
                            {{$list[$i]->title}}
                        </a>
                        <div style="font-size:14px;margin:10px 0;">
                            <span>领队：<a href="#">{{$list[$i]->leader}}</a></span>
                            <span style="margin-left:50px;">联系电话：{{$list[$i]->phone}}</span>
                            <span style="margin-left:50px;"><span  style="color:darkorange">强度</span>：{{$list[$i]->qiangdu}}</span>
                        </div>
                        <div style="font-size:14px;margin:10px 0;">
                            <span>目的地：<a href="#">{{$list[$i]->mudidi}}</a></span>
                            <span style="margin-left:50px;">出发时间：{{$list[$i]->startday}}</span>
                            <span style="margin-left:50px;">返回时间：{{$list[$i]->endday}}</span>
                        </div>
                        <div style="font-size:14px;margin:10px 0;">
                            <span>交通方式：<a href="#">{{$list[$i]->jiaotong}}</a></span>
                            <span style="margin-left:50px;">需要：<a href="#">{{$list[$i]->need}}</a>人</span>
                            <span style="margin-left:50px;">报名：<a href="#">{{$list[$i]->baoming}}人</a></span>
                            <span style="margin-left:10px;vertical-align: middle" class="glyphicon glyphicon-eye-open" ></span>
                            <span style="margin-left:5px;" >{{$list[$i]->readcnt}}</span>
                        </div>
                        <div style="font-size:14px;margin:10px 0;">
                            <span>活动内容：<a href="#">{{$list[$i]->neirong}}</a></span>
                        </div>
                        <div style="font-size:14px;margin:10px 0;max-width:500px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">
                            <span>活动特色：<a href="#">{{$list[$i]->tese}}</a></span>
                        </div>
                        <button onclick="baoming({{$list[$i]->id}})" type="button" class="btn btn-info"
                                style="width:110px;height:40px;font-size: 20px;outline:none;position:absolute;right:10px;bottom:50px;">马上报名</button>
                    </div>
                </div>
                @endfor
            </div>
            <div class="right">
                <p style="color:#999;font-size:20px;margin-top:-40px;">精彩回顾</p>
                @for( $i=0;$i<count($youjis);$i++ )
                    <a href="/youji/detail/{{$youjis[$i]->id}}">
                        <div style="width:100%;height:200px;margin-bottom:20px;color:#444;" >
                            <div style="height:150px;width:300px;float:left;background-size:cover;background-position: center;background-repeat:no-repeat;background-image:
                            @if($youjis[$i]->type == 2)
                                    url(/admin/data/images/{{$youjis[$i]->pic}})
                            @else
                                    url(/web/data/images/{{$youjis[$i]->pic}})
                            @endif
                                    ;" ></div>
                            <p style="line-height:25px;padding-right:10px;" >{{$youjis[$i]->title}}</p>
                        </div></a>
                @endfor
            </div>
        <div style="clear:both" ></div>
        {!! $fenye !!}
    </div>


    @include("web.footer")

@stop

@section("htmlend")
    <script>
        function baoming(id) {
            $.post("/tubu/baoming",{"tid":id},function(d){
                if( ajaxdata(d) ) {
                    toast("报名成功");
                }
            })
        }
    </script>
@stop