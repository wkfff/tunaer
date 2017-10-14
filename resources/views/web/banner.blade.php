
<link rel="stylesheet" href="/web/css/swiper-3.4.2.min.css">

<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php
            if( empty(Session::get("banners")) ) {
                $sql = " select * from banner order by sort desc ";
                $banners = DB::select($sql);
                Session::put("banners",$banners);
            }
            $banners = Session::get("banners");

        ?>
        @for( $i=0;$i<count($banners);$i++ )
                <div onclick="location.href='{{$banners[$i]->url}}'" class="swiper-slide" title="{{$banners[$i]->title}}" style="background-image:url(/admin/data/images/{{$banners[$i]->pic}});"></div>
        @endfor
        {{--<div class="swiper-slide" style="background-image:url(/web/images/banner0.jpg);"></div>--}}
        {{--<div class="swiper-slide" style="background-image:url(/web/images/banner1.jpg);"></div>--}}
        {{--<div class="swiper-slide" style="background-image:url(/web/images/banner2.jpg);"></div>--}}
        {{--<div class="swiper-slide" style="background-image:url(/web/images/banner3.jpg);"></div>--}}
        {{--<div class="swiper-slide" style="background-image:url(/web/images/banner4.jpg);"></div>--}}
    </div>
    <!-- 如果需要分页器 -->
    <div class="swiper-pagination"></div>
</div>

<style>
    .swiper-container {
        width: 100%;    
        height: 500px;
    }  
    .swiper-slide{
        background-size:cover;background-repeat:no-repeat;background-position:center;
    }
    .swiper-pagination-bullet-active{
        background: #194C8E !important;
    }
</style>
<script src="/web/js/swiper-3.4.2.jquery.min.js" ></script>
<script>
    $(document).ready(function () {
        var mySwiper = new Swiper ('.swiper-container', {
            // direction: 'vertical',
            loop: true,
            
            // 如果需要分页器
            pagination: '.swiper-pagination'
        })   
    });     
</script>
