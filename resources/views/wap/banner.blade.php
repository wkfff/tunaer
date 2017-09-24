
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

    </div>
</div>

<style>
    .swiper-container {
        width: 99%;
        height: 150px;
        margin:0 auto;
        /*border-radius:3px;*/
        margin-top:50px;
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
            autoplay:5000,
            loop: true,

            // 如果需要分页器
//            pagination: '.swiper-pagination'
        })
    });
</script>