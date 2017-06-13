<?php
$this->title = '首页';
?>
<?php $banner = focus(1, 5, '1440x750')?>
<div class="panel"  data-section-name="page1">
    <div class="pbanner index-banner">
        <div class="fadeOut owl-carousel">
            <?php foreach ($banner as $item): ?>
            <a href="<?=$item["link"]?>" target="_blank">
                <div class="item" style="background-image:url(<?=$item['image']?>)"></div>
            </a>
            <?php endforeach;?>
        </div>
        <div class="move"><span></span><i></i></div>
    </div>
    <div class="index-banner mbbanner">
        <div class="fadeOut owl-carousel">
            <a href="" target="_blank">
                <div class="item" style="background-image:url(/theme/juding/static/images/591fe6f26c25e.jpg)"></div>
            </a>
            <a href="" target="_blank"><div class="item" style="background-image:url(/theme/juding/static/images/586315d1d0679.jpg)"></div></a>
            <a href="" target="_blank"><div class="item" style="background-image:url(/theme/juding/static/images/5937c6fea8fdd.jpg)"></div></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".pbanner .owl-carousel").owlCarousel({
        margin: 40,
        nav: true,
        loop: true,
        autoplay:true,
        autoplayTimeout:3000,
        smartSpeed:1000,
        responsive: {
            0: {
                items: 1
            },
        }
    });

    $(".mbbanner .owl-carousel").owlCarousel({
        margin: 40,
        nav: true,
        loop: true,
        autoplay:true,
        autoplayTimeout:3000,
        smartSpeed:1000,
        responsive: {
            0: {
                items: 1
            },
        }
    });
</script>

<?php $products = productCateByType(1, 5)?>
<div class="section section2">
    <!-- <div class="section"> -->
    <div class="index-zhanting" >
        <div style="height:40px"></div>
        <div class="index-title" >
            <h2>产品展厅</h2>
            <p>Product display</p>
            <img src="/theme/juding/static/picture/index_title.png" alt="" />
        </div>
        <ul class="index-head zhanting-head">
            <?php foreach ($products as $k => $p): ?>
                <li class="<?php if($k==1)echo 'on';?>" >
                    <a href="javascript:void(0);"><?=$p['name']?></a>
                </li>
            <?php endforeach;?>
        </ul>

        <div class="zhanting-toggle containerBox"  >
            <?php foreach ($products as $key => $product): ?>
            <div class="zhanting-body">

                <div class="loop owl-carousel" >
                <?php if (isset($product['child'])):?>
                    <?php foreach ($product['child'] as $k => $p): ?>
                    <div class="item"  >
                        <a href="<?=url(['/shop/home/default/view', 'id'=>$p['id']])?>"
                           title="<?=$p['name']?>" target="_blank" class="pic">
                            <img originalSrc="<?=$p['cover']?>" alt="<?=$p['name']?>" />
                        </a>
                    </div>
                    <?php endforeach;?>
                <?php endif;?>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>

</div>



































<div class="index-dongtai wrap section3">
    <div class="index-title">
        <h2>品牌动态</h2>
        <p>Brand dynamic</p>
        <img src="/theme/juding/static/picture/index_title.png" alt="" />
    </div>

    <?php $news = newsCates(null, 10, '373x249')?>
    <ul class="index-head dongtai-head">
        <?php foreach ($news as $k => $cate):?>
        <li class="<?php if($k==1)echo'on'?>">
            <a href="javascript:void(0);" s="<?=url(['/news/home/default/index', 'cid'=>$cate['id']])?>"><?=$cate['name']?></a>
        </li>
        <?php endforeach;?>
    </ul>
    <div class="dongtai-toggle containerBox">

        <?php foreach ($news as $key => $cate):?>
        <div class="dongtai-body">
            <div class="owl-carousel">

            <?php foreach ($cate['child'] as $k => $v):?>
                <div class="item clearfix">
                    <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>" class="dongtai-pic pic" target="_blank" title="<?=$v['title']?>">
                        <img originalSrc="<?=$v['cover']?>" alt="<?=$v['title']?>"/>
                    </a>
                    <div class="dongtai-text">
                        <h2><a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>" class="fx" target="_blank"><?=$v['title']?></a></h2>
                        <p><?=$v['summary']?></p>
                    </div>
                    <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>" class="dongB clearfix">
                        <div class="fl">
                            <h3><?=date('m-d', $v['created_at'])?></h3>
                            <i><?=date('Y', $v['created_at'])?></i>
                        </div>
                        <span class="fr"></span>
                    </a>
                </div>
            <?php endforeach;?>
            </div>
        </div>

        <?php endforeach;?>

    </div>
    <a href="<?=url('/news/home/default/index')?>" target="_blank" class="see-more go-more">查看更多 <i>+</i></a>
</div>

<div class="index-case wrap" style="padding-bottom: 80px;">

    <div class="index-title">
        <h2>成功案例</h2>
        <p>Classic case</p>
        <img src="/theme/juding/static/picture/index_title.png" alt="" />
    </div>

    <?php $case = cmsArticle(1, null, 5, '270x180');?>
    <ul class="index-head case-head">
        <?php foreach ($case['list'] as $k => $v): ?>
        <li class="<?php if($k==0)echo'on';?>" >
            <a href="javascript:void(0);"><?=$v['name']?></a>
        </li>
        <?php endforeach;?>
    </ul>
    <div class="case-toggle containerBox">
        <?php foreach ($case['list'] as $key => $list): ?>
        <div class="case-body">
            <div class="owl-carousel">
                <?php if (isset($list['child'])):?>
                    <?php $i=1 ;foreach ($list['child'] as $k => $v): ?>
                        <?php if ($i%2):?>
                        <div class="item clearfix <?=$i?>" >
                        <?php endif;?>
                            <div class="case-block case-mb" >
                                <a href="<?=url(['/cms/home/case/view', 'id'=>$v['id']])?>"  target="_blank">
                                    <div class="pic">
                                        <img originalSrc="<?=$v['cover']?>" alt="<?=$v['title']?>" />
                                    </div>
                                    <h3><?=$v['title']?></h3>
                                </a>
                            </div>
                        <?php if ($i%2 == 0):?>
                        </div>
                        <?php endif;?>
                    <?php $i++; endforeach;?>
                        <?php if ($i%2 == 0):?>
                        </div>
                        <?php endif;?>
                <?php endif;?>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <a href="<?=url(['/cms/home/case/index'])?>" class="see-more" target="_blank">查看更多 <i>+</i></a>
</div>


<script type="text/javascript" src="/theme/juding/static/js/lazyload.js"></script>
<script type="text/javascript">
    $(function(){
        var imgH = $(".zhanting-body .item").width()/1.6363636363;
        $('.zhanting-body .item').css('height',imgH);
        var imgH2 = $(".dongtai-toggle .pic").width()/1.50366748166;
        $('.dongtai-toggle .pic').css('height',imgH2);
        var imgH3 = $(".index-media .pic").width()/1.5;
        $('.index-media .pic').css('height',imgH3);
        var imgH4 = $(".index-case .case-block .pic").width()/1.3809523809;
        $('.index-case .case-block .pic').css('height',imgH4);
        $(window).on('load resize', function(event) {
            var imgH = $(".zhanting-body .item").width()/1.6363636363;
            $('.zhanting-body .item').css('height',imgH);
            var imgH2 = $(".dongtai-toggle .pic").width()/1.50366748166;
            $('.dongtai-toggle .pic').css('height',imgH2);
            var imgH3 = $(".index-media .pic").width()/1.5;
            $('.index-media .pic').css('height',imgH3);
            var imgH4 = $(".index-case .case-block .pic").width()/1.3809523809;
            $('.index-case .case-block .pic').css('height',imgH4);


        });
        $(".containerBox img").delayLoading({
            defaultImg: "/theme/juding/static/images/blank.png",
            errorImg: "",
            imgSrcAttr: "originalSrc",
            beforehand: 0,
            event: "scroll",
            duration: "normal",
            container: window
        });
        $('.section3 ul li a').click(function(){
            var url = $(this).attr('s');
            if(url != null){
                $('.go-more').attr('href',url);
            }
        });

    })
</script>


<script type="text/javascript" src="/theme/juding/static/js/jquery.mousewheel.js"></script>
<script>
    $(window).on('load resize',function(event){
        var winW = $(window).width();
        if(winW>640){
            $(function(){
                var a=0,c;
                $(window).on("scroll resize",function(){
                    var b = $(window).scrollTop();

                    var step = $(window).height();            //可视区高度

                    if(a < b) {
                        clearTimeout(c)
                        c = setTimeout(function(){
                            if( $(window).scrollTop() > 0 && $(window).scrollTop() < $(window).height()) {
                                $("html,body").stop().animate({
                                    "scrollTop":$(".section2").offset().top
                                },500);


                            }

                        },50)

                    }else if(a > b){
                        clearTimeout(c)
                        c = setTimeout(function(){
                            if( $(window).scrollTop() > 0 && $(window).scrollTop() < $(window).height()) {
                                $("html,body").stop().animate({
                                    "scrollTop":0
                                },500);

                            }

                        },50)
                    }
                    a = b;
                })
            })
        }
    })

</script>

<script type="text/javascript" src="/theme/juding/static/js/index.js"></script>
<script type="text/javascript">
    $(function(){
        // indexB(".pbanner .owl-carousel");
        // indexB(".mbbanner .owl-carousel");
        $('.zhanting-body .loop').owlCarousel({
            center: true,
            items: 1,
            loop: true,
            margin: 0,
            nav:true,
            responsiveRefreshRate:50,
            smartSpeed:1000,
            responsive: {
                600: {
                    items: 1.6,
                    margin: 80
                },
                1200: {
                    items: 1.6,
                    margin: 100
                }
            }
        });
        $(".dongtai-body .owl-carousel").owlCarousel({
            margin: 40,
            nav: true,
            loop: false,
            smartSpeed:1000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
        $(".case-body .owl-carousel").owlCarousel({
            margin: 40,
            nav: true,
            loop: false,
            smartSpeed:1000,
            responsive: {
                0: {
                    items: 2,
                    margin: 10
                },
                800: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });

        // logo
        $(window).scroll(function(){
            if($(window).scrollTop() > $(window).height()){
                $(".logo1").hide();
                $(".logo2").show();
            }else{
                $(".logo1").show();
                $(".logo2").hide();
            }
        });
    });
    // function indexB(obj){
    //     $(obj).owlCarousel({
    //         items: 1,
    //         animateOut: 'fadeOut',
    //         loop: true,
    //         margin: 0,
    //         nav:true,
    //         autoplay:true,
    //         smartSpeed:400,
    //         autoplayHoverPause:true,
    //         responsiveRefreshRate:50
    //     });
    // }

</script>
