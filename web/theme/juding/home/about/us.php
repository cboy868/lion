<?php
$this->title = "关于我们";
?>
<script src="/theme/juding/static/js/swiper.js"></script>
<?php $banner = focus(2, 1, '1440x580')?>
<div class="inside-focus">
    <?php foreach ($banner as $item): ?>
    <img src="<?=$item['image']?>" alt="">
    <?php endforeach;?>
</div>

<div class="inside-local wrap">
    <div class="pos"><b></b>
        <span>当前位置：
            <a href="/">网站首页</a> &gt;
            <a href="<?=url(['/cms/home/about/us'])?>">关于我们</a>
        </span>
    </div>
</div>
<div class="inside-title">
    <h2 class="en">COMPANY PROFILE</h2>
    <h2 class="cn">企业概况</h2>
</div>
<?php $list = cmsImages(3, 4, 5, '624x385')?>

<div class="profile1">
    <div class="wrap">
        <div class="owl-carousel profile1-carousel">
            <?php $index=1;foreach ($list['list']['child'] as $album): ?>
            <div class="item clearfix item_c">
                <div class="profile1-pic fl ">
                    <div class="profile_slideBox profile_slideBox3">
                        <div class="hd">
                            <ul>
                                <?php $i=1; foreach ($album['images'] as $img):?>
                                    <li><?=$i?></li>
                                <?php $i++; endforeach;?>
                            </ul>
                        </div>
                        <div class="profile_bd ">
                            <ul>
                                <?php foreach ($album['images'] as $img):?>
                                    <li><img src="<?=$img['url']?>"></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="profile1-text fr">
                    <h2><?=$album['title']?></h2>
                    <div class="scroll">
                        <p>
                            <?=$album['summary']?>
                        </p>
                    </div>
                </div>
            </div>
            <?php $index++; endforeach;?>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(".profile_slideBox").slide({mainCell:".profile_bd ul",autoPlay:true,delayTime:1000,interTime:5000});
</script>
<!-- 手机端 -->

<?php $list = cmsArticle(3, 6, 20, '1199x587')?>

<div class="mprofile2">
    <div class="wrap">
        <div class="mprofile2-top">
            <div class="swiper-container gallery-thumbs">
                <div class="swiper-wrapper">
                    <?php foreach ($list['list']['child'] as $v): ?>
                    <div class="swiper-slide"><?=$v['title']?></div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="swiper-button-next swiper-button-white"> > </div>
            <div class="swiper-button-prev swiper-button-white"> < </div>
        </div>

        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
                <?php foreach ($list['list']['child'] as $v): ?>
                <div class="swiper-slide">
                    <img src="<?=$v['cover']?>" alt="<?=$v['title']?>" />
                    <div class="slide-text">
                        <h2><?=$v['title']?></h2>
                        <p><?=$v['body']?></p>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <!-- Add Arrows -->
        </div>
        <!-- Initialize Swiper -->
        <script>
            var galleryTop = new Swiper('.gallery-top', {
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                spaceBetween: 10,
            });
            var galleryThumbs = new Swiper('.gallery-thumbs', {
                spaceBetween: 10,
                centeredSlides: true,
                slidesPerView: 'auto',
                touchRatio: 0.2,
                slideToClickedSlide: true
            });
            galleryTop.params.control = galleryThumbs;
            galleryThumbs.params.control = galleryTop;

        </script>
    </div>
</div>

<!-- pc端 -->
<div class="profile2 clearfix">
    <div class="profile2-pic">
        <ul>
            <?php foreach ($list['list']['child'] as $v): ?>
            <li>
                <img src="<?=$v['cover']?>" alt="" title="<?=$v['title']?>" style="height:587px;" />
                <div class="text">
                    <h2><?=$v['title']?></h2>
                    <p><?=$v['body']?></p>
                </div>
            </li>
            <?php endforeach;?>
        </ul>
        <div class="profile2-arrow">
            <div class="arrow">
                <a href="javascript:void(0);" class="profile2-prev"></a>
                <a href="javascript:void(0);" class="profile2-next"></a>
            </div>
        </div>
    </div>
    <div class="profile2-dot">
        <div class="profile2-dot-wrap">
            <a href="javascript:void(0);" class="profile2-dot-left"></a>
            <div class="profile2-dot-c">
                <ol>
                </ol>
            </div>
            <a href="javascript:void(0);" class="profile2-dot-right"></a>
        </div>
    </div>
</div>

<!-- 董事长寄语 -->
<?php $article = cmsArticleDetail(3, 5, '600x443');?>
<div class="about-xns">
    <div class="profile3">
        <div class="wrap clearfix">
            <div class="pic"><img src="<?=$article['cover']?>" alt="<?=$article['title']?>" /></div>
            <div class="text">
                <h2><?=$article['title']?></h2>
                <div class="scroll2">
                    <p>
                        <?=$article['body']?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $list = cmsArticle(3, 5, 7, '360x270')?>
<!-- 团队展示 -->
<div class="profile5">
    <div class="wrap">
        <h2>团队展示</h2>
        <ul class="profile5-list">
            <?php foreach ($list['list']['child'] as $v):?>
            <li class="clearfix ss" data-id="<?=$v['id']?>">
                <div class="ac" style="display: none;">
                    <?=$v['body']?>
                </div>
                <div class="pic fl" >
                    <img src="<?=$v['cover']?>" alt="<?=$v['title']?>" />
                </div>
                <div class="text fl">
                    <div class="text-c">
                        <h2><?=$v['title']?></h2>
                        <h3><?=$v['subtitle']?></h3>
                        <p ><?=$v['summary']?></p>
                    </div>
                </div>
            </li>
            <?php endforeach;?>
        </ul>
        <?php $list = cmsArticle(3, 7, 7, '360x270')?>
        <div class="owl-carousel profile5-focus">

            <?php foreach ($list['list']['child'] as $v):?>
            <div class="item ds"  data-fid="<?=$v['id']?>">
                <div class="ac" style="display: none;">
                    <?=$v['body']?>
                </div>
                <img src="<?=$v['cover']?>" alt="<?=$v['title']?>" />
                <h3><?=$v['title']?></h3>
                <p><?=$v['summary']?></p>
            </div>
            <?php endforeach;?>
        </div>

    </div>
</div>
<?php $article = cmsArticleDetail(3, 8, '1200x637');?>
<div class="profile6">
    <div class="wrap">
        <img src="<?=$article['cover']?>" alt="<?=$article['title']?>" />
    </div>
</div>
<div class="profile-layout">
    <div class="profile-layout-c">
        <div class="profile-content clearfix">
            <div class="pic fl am" >
                <img src="#" alt="" />
                <!-- <img src="/Public/guangfan/images/profile5_pic1.jpg" alt="" /> -->
            </div>
            <div class="text fr" id="cb">
                <!-- <h2>王刚<span>(軒尼斯门窗品牌总监）</span></h2>
                <p></p> -->
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('.ss').click(function(){
        var body = $(this).find('.ac').text();
        var imgsrc = $(this).find('.pic img').attr('src');
        var img = '<img src="'+imgsrc+'">';
        var obj = $('.profile-layout');
        var title = $(this).find('.text-c').find('h2').text();
        var subtitle = $(this).find('.text-c h3').text();
        var text = '<h2>'+title+'<span>'+'('+subtitle+')'+'</span></h2>'+'<p>'+body+'</p>';
        $('.am', obj).html(img);
        $('#cb', obj).html(text);
    });


    $('.ds').click(function(){

        var body = $(this).find('.ac').text();
        var imgsrc = $(this).find('img').attr('src');
        var img = '<img src="'+imgsrc+'">';
        var obj = $('.profile-layout');
        var title = $(this).find('h3').text();
        var text = '<h2>'+title+'</h2>'+'<p>'+body+'</p>';
        $('.am', obj).html(img);
        $('#cb', obj).html(text);
    });
</script>

<script type="text/javascript" src="/theme/juding/static/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/theme/juding/static/js/jScrollPane.js"></script>
<script type="text/javascript" src="/theme/juding/static/js/index.js"></script>
<script type="text/javascript">
    $(function(){
        // logo
        $(window).scroll(function(){
            if($(window).scrollTop() > $(".inside-focus img").height()){
                $(".logo1").hide();
                $(".logo2").show();
            }else{
                $(".logo1").show();
                $(".logo2").hide();
            }
        });
        $(".profile1-carousel").owlCarousel({
            items: 1,
            loop: false,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed:1000,
            autoplayHoverPause: true
        });
        // $(".profile1-pic .owl-carousel").owlCarousel({
        //     items: 1,
        //     loop: false,
        //     margin: 10,
        //     autoplay: true,
        //     autoplayTimeout: 2000,
        //     smartSpeed:1000,
        //     autoplayHoverPause: true
        // });

        $(".profile1-text .scroll").jScrollPane();
        $(".profile3 .text .scroll2").jScrollPane();
        $(".profile5-focus").owlCarousel({
            margin: 60,
            nav: true,
            loop: false,
            smartSpeed:1000,
            responsive: {
                0: {
                    items: 1,
                    margin:0
                },
                600: {
                    items: 2,
                    margin: 20
                },
                1000: {
                    items: 3
                }
            }
        });

    });
</script>