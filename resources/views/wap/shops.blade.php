@extends("wap.common")
@section("title","徒步装备")
@section("css")
    <link rel="stylesheet" href="/web/css/swiper-3.4.2.min.css">
    <style>

        .tubuitem{
            width:99%;height:200px;background-size:cover;margin:0 auto;
            background-position:center;
            background-repeat:no-repeat;margin-top:7.5px;
            /*display: inline-block;*/
            position: relative;
        }
        .swiper-container {
            width: 100%;margin-bottom:-20px;
            height: 180px;
        }
        .swiper-slide{
            background-size:cover;background-repeat:no-repeat;background-position:center;
        }
        .swiper-pagination-bullet{
            border-radius:0 !important;
            width:15px !important;height:1px !important;backrgound:red !important;
        }
        .swiper-pagination-bullet-active{
            background: deeppink !important;
            border-raidus:0 !important;
        }
        .shopitem{
            height:130px;width:100%;margin:10px 0;
            padding:15px 5px;background: white;
            position: relative;
        }
        .shoppic{
            height:100px;width:100px;background-position:center;background-size:cover;float:left;
            margin-right:10px;
        }
        select{
            width:100% !important;margin-left:0%;margin-top:5px;
        }
    </style>
@stop

@section("body")
    @if( Session::get('uid') )
    <a href="/shoporder"><div style="position: fixed;right:5px;bottom:70px;line-height:50px;font-size:14px;width:50px;height:50px;background:orange;z-index:999;text-align:center;border-radius:25px;color:#fff;"  >订单</div></a>
    @else
        <a href="javascript:openlogion()"><div style="position: fixed;right:5px;bottom:70px;line-height:50px;font-size:14px;width:50px;height:50px;background:orange;z-index:999;text-align:center;border-radius:25px;color:#fff;"  >订单</div></a>
    @endif
    <div  style="width:100%;height:55px;background:rgba(255,255,255,1);color:#666;position:fixed;left:0px;top:0px;z-index:999;text-align:center;line-height:55px;border-bottom:1px solid #ddd;font-weight:bold;font-size:16px;letter-spacing: 3px;">
        <span onclick="history.back()" style="float:left;position: absolute;left:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-menu-left" ></span>
        <span>徒步装备</span>
        <span data-toggle="modal" data-target="#myModal2" style="position: absolute;right:10px;top:0px;line-height:55px;" class="glyphicon glyphicon-search" ></span>

    </div>
    <div class="content" style="margin-top:55px;background:#efefef" >
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                if( empty(Session::get("shopbanners")) ) {
                    $sql = " select * from shopbanner order by sort desc ";
                    $banners = DB::select($sql);
                    Session::put("shopbanners",$banners);
                }
                $banners = Session::get("shopbanners");

                ?>
                @for( $i=0;$i<count($banners);$i++ )
                    <div onclick="location.href='{{$banners[$i]->url}}'" class="swiper-slide" title="{{$banners[$i]->title}}" style="background-image:url(/admin/data/images/{{$banners[$i]->pic}});"></div>
                @endfor
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
        </div>

        <div class="shoplist" style="padding-top:20px;min-height:500px;" >
            @if( count($list) == 0 )
                <p>没有找到商品~</p>
            @endif
            @for( $i=0;$i<count($list);$i++ )
                <a href="/shop/detail/{{$list[$i]->id}}">
                    <div class="shopitem" >
                        <div class="shoppic" style="background-image:url(/admin/data/images/{{$list[$i]->pictures}});" ></div>
                        <span style="font-size:18px;color:#333;">{{$list[$i]->title}}</span>

                        <div style="padding:0 10px;position: absolute;right:0px;bottom:0px;">
                            <span style="color:#F40;font-size:18px;margin-right:10px;line-height:30px;">¥{{$list[$i]->price}}</span>
                            <span style="float:right;color:#888;font-size:13px;line-height:30px;">已售{{$list[$i]->sold}}件</span>
                        </div>
                    </div>
                </a>
            @endfor
        </div>

        <div style="clear:both" ></div>
        {!! $fenye !!}

    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:100%">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">搜索徒步装备</h4>
                </div>
                <div class="modal-body">
                    <p style="height:40px;background:none;color:#fff;text-align: left;line-height:40px;font-size: 16px;margin:0px;position:relative;border-bottom:1px solid #999;width:80%;margin:0 auto;">
                        <input class="searchkey" placeholder="搜索商品" type="text" style="height:40px;width:100%;border:none;background:none;text-align: center;font-size:14px;color:#666;letter-spacing: 2px;">
                    </p>
                    <div class="sort">
            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button onclick="searchkey()" type="button" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </div>
    </div>
    @include("wap.footer")

@stop

@section("htmlend")
    <script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
    <script>
        $(document).ready(function () {
            var mySwiper = new Swiper ('.swiper-container', {
                // direction: 'vertical',
                loop: true,

                // 如果需要分页器
                pagination: '.swiper-pagination'
            })
            loadfenlei();
        });
        function loadfenlei() {
            var data = eval({!! $fenlei !!});
            for( var i=0;i<data.length;i++ ) {
                if( $(".sort"+data[i].id).length == 0 ) {
                    $(".sort").append("<a style='margin:10px 0;display:block;color:#666;font-size:16px;text-align:center' href='/shops/sort/"+data[i].id+"' class='sort"+data[i].id+"'><span  >"+data[i].title+"</span></a>");
                }
            }
            $(".sort").append("<a style='margin:10px 0;display:block;color:#666;font-size:16px;text-align:center' href='/shops' ><span  >所有装备</span></a>");
        }
        function searchkey() {

            var key = $(".searchkey").val();
            if( $.trim(key) != '' ) {
                location.href="/shops/key/"+key;
            }
            zuzhi(event);
        }
    </script>

@stop