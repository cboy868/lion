<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/index.css">
<div class="index">

    <?php
    $banner = focus(1, 3, '1920x450')
    ?>

    <div class="full_slider">
        <ul class="slider_main">



            <?php foreach ($banner as $k => $v):?>
                <li style="<?php if($k==0):?>display:block;<?php endif;?>background-image:url(<?=$v['image']?>)"><a href="<?=$v['link']?>"></a></li>
            <?php endforeach;?>

<!--            <li style="display:block; background-image:url(http://www.shfsy.com/uploads/images2/450.jpg)"><a href="#"></a></li>-->
<!--            <li style="background-image:url(http://placehold.it/1920x450)"><a href="#"></a></li>-->
<!--            <li style="background-image:url(http://www.shfsy.com/uploads/images2/450.jpg)"><a href="#"></a></li>-->
        </ul>
        <div class="btns">
            <?php foreach ($banner as $k => $v):?>
                <span class="<?php if($k==0):?>active<?php endif;?>"></span>
            <?php endforeach;?>
        </div>
    </div>
    <div class="container">
        <div class="wrap-item youku-news">
            <div class="impor-news">
                <h2 class="title ico ico1">
                    <a href="<?=Url::toRoute(['/news/home/default/index'])?>" class="more-green right">more</a>
                    <?=g('cp_name')?>新闻
                </h2>
                <?php
                    $news = news(null, 15);
                ?>
                <div class="inner scroll-news">
                    <?php foreach ($news as $k => $item):?>
                    <dl>
                        <dt>
                            <span class="right"><?=date('Y-m-d H:i',$item['created_at'])?></span>
                            <a href="<?=Url::toRoute(['/news/home/default/view', 'id'=>12])?>"><?=$item['title']?></a>
                        </dt>
                        <dd><a href="<?=Url::toRoute(['/news/home/default/view', 'id'=>12])?>"><?=$item['subtitle']?></a></dd>
                    </dl>
                    <?php endforeach;?>
                </div>
            </div>

            <div class="youku">
                <h2>2013年 <?=g('cp_name')?>元年纪事</h2>
                <div id="a1"></div>
                <script type="text/javascript" src="/theme/m2/static/libs/CKplayer/ckplayer/ckplayer.js" charset="utf-8"></script>
                <script type="text/javascript">
                    var flashvars={
                        f:'http://gls.gls024.com/static/upload/gls_xc.flv',
                        c:0,
                        p:1,
                        wh:'16:9',
                        h:2
                    };
                    var params={bgcolor:'#FFF',allowFullScreen:true,allowScriptAccess:'always',wmode:'transparent'};
                    CKobject.embedSWF('/theme/m2/static/libs/CKplayer/ckplayer/ckplayer.swf','a1','ckplayer_a1','828','490',flashvars,params);
                </script>
            </div>
        </div><!--/wrap-item-->
        <div class="wrap-item media-focus">
            <h2 class="title ico ico2">
                <a href="#" class="more-green right">more</a>
                媒体聚焦
            </h2>
            <?php
            $news = news(4, 4, '280x270');
            ?>
            <div class="inner">
                <?php foreach ($news as $k => $v): ?>
                <div class="figure shadow">
                    <a href="#"><img src="<?=$v['cover']?>" alt=""></a>
                    <a href="#" class="play-ico"><img src="/theme/m2/static/gls/img/global/play-ico.png" alt=""></a>
                    <h3><?=$v['title']?></h3>
                    <p class="figcaption">
                        <?=$v['subtitle']?>
                    </p>
                </div>
                <?php endforeach;?>
            </div>
        </div><!--/wrap-item-->
        <div class="wrap-item">
            <?php
            $news = news(1, 4, '280x270');
            ?>
            <h2 class="title ico ico3">
                <a href="#" class="more-green right">more</a>
                <?=g('cp_name')?>专题
            </h2>
            <div class="inner">
                <?php foreach ($news as $k => $v):?>
                <div class="figure shadow">
                    <a href="#"><img src="<?=$v['cover']?>" alt=""></a>
                    <h3><?=$v['title']?></h3>
                    <p class="figcaption">
                        <?=$v['subtitle']?>
                    </p>
                </div>
                <?php endforeach;?>
            </div>
        </div><!--/wrap-item-->
        <div class="wrap-item deve">
            <h2 class="title title-green ico ico4">
                <?=g('cp_name')?>动态
            </h2>
            <div class="inner tabbox clearfix">
                <div class="items">
                    <h2>
                        <a href="#" class="more-green right">more</a>
                        员工日志
                    </h2>
                    <div class="bor">
                        <div class="tab">
                            <div class="tabtit">
                                <a href="javascript:;" class="first active">服务故事</a>
                                <a href="javascript:;">学习创新</a>
                                <a href="javascript:;"><?=g('cp_name')?>生活</a>
                            </div>
                            <div class="tabcon">
                                <ul class="news_list" style="display:block;">
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                </ul>
                                <ul class="news_list">
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                </ul>
                                <ul class="news_list">
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="items">
                    <h2>
                        <a href="#" class="more-green right">more</a>
                        资讯
                    </h2>
                    <div class="bor">
                        <div class="tab">
                            <?php
                            $news1 = news(2, 8);
                            $news2 = news(3, 8);
                            $news3 = news(4, 8);
                            ?>
                            <div class="tabtit">
                                <a href="javascript:;" class="first active">客户服务</a>
                                <a href="javascript:;">交流活动</a>
                                <a href="javascript:;">媒体聚焦</a>
                            </div>
                            <div class="tabcon">
                                <ul class="news_list" style="display:block;">
                                    <?php foreach ($news1 as $k => $v):?>
                                    <li><span class="right">
                                        <a class="name" href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>"><?=$v['author']?></a>
                                        <?=date('Y-m-d H:i',$v['created_at'])?></span>
                                        <a class="txt" href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>"><?=$v['title']?></a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                                <ul class="news_list">
                                    <?php foreach ($news2 as $k => $v):?>
                                        <li><span class="right">
                                        <a class="name" href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>"><?=$v['author']?></a>
                                                <?=date('Y-m-d H:i',$v['created_at'])?></span>
                                            <a class="txt" href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>"><?=$v['title']?></a>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                                <ul class="news_list">
                                    <?php foreach ($news3 as $k => $v):?>
                                        <li><span class="right">
                                        <a class="name" href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>"><?=$v['author']?></a>
                                                <?=date('Y-m-d H:i',$v['created_at'])?></span>
                                            <a class="txt" href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>"><?=$v['title']?></a>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="items">
                    <h2>
                        <a href="#" class="more-green right">more</a>
                        客户博客
                    </h2>
                    <div class="bor">
                        <div class="tab">
                            <div class="tabtit">
                                <a href="javascript:;" class="first active">我与<?=g('cp_name')?></a>
                                <a href="javascript:;">我的亲人</a>
                                <a href="javascript:;">思念亲人</a>
                            </div>
                            <div class="tabcon">
                                <ul class="news_list" style="display:block;">
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信1</a></li>
                                </ul>
                                <ul class="news_list">
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信2</a></li>
                                </ul>
                                <ul class="news_list">
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                    <li><span class="right"><a class="name" href="#">用户名</a>02-21</span><a class="txt" href="#">可爱的微信3</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/wrap-item-->
        <div class="wrap-item process">
            <h2 class="title title-green ico ico5">
                购墓服务流程
            </h2>
            <div class="inner clearfix">
                <a href="javascript:;">
                    <span>01</span>
                    <h3>预约参观</h3>
                    <h4>An appointment to visit</h4>
                </a>
                <div class="tip">
                    <p>电话预约<?=g('cmobile')?>，营销接待中心为您准备免费参观车辆。</p>
                </div>
                <a href="javascript:;">
                    <span>02</span>
                    <h3>乘车来园</h3>
                    <h4>To get to the park</h4>
                </a>
                <div class="tip">
                    <p>根据预约的时间、乘坐免费参观车，亦可自行驾车参观。</p>
                </div>
                <a href="javascript:;">
                    <span>03</span>
                    <h3>墓穴选购</h3>
                    <h4>The tomb of choose and buy</h4>
                </a>
                <div class="tip">
                    <p>引导员为您详细介绍企业文化及墓穴产品，并带您实地参观讲解。</p>
                </div>
                <a href="javascript:;">
                    <span>04</span>
                    <h3>确定墓穴</h3>
                    <h4>Determination of the grave</h4>
                </a>
                <div class="tip">
                    <p>如果您选择了符合要求的墓穴有以下两种方式：<br>A.您可以交付预定金500元；<br>B.您也可以直接交付全款并签订墓穴使用协议办理各项手续。</p>
                </div>
                <a href="javascript:;">
                    <span>05</span>
                    <h3>预约安葬</h3>
                    <h4>Make an appointment</h4>
                </a>
                <div class="tip">
                    <p>在安葬前15天办理碑文手续，选择配套商品和礼仪产品，确定安葬日期。</p>
                </div>
                <a href="javascript:;">
                    <span>06</span>
                    <h3>安葬</h3>
                    <h4>Buried</h4>
                </a>
                <div class="tip">
                    <p>至安葬登记处登记，首次免费安葬，如需安葬礼仪提前预约。</p>
                </div>
            </div>
        </div><!--/wrap-item-->
        <div class="wrap-item after-sales">
            <h2 class="title ico ico6">
                售后服务项目
            </h2>
            <div class="inner clearfix">
                <div class="shadow">
                    <div class="after-item">
                        <img src="/theme/m2/static/gls/img/index/1.png" alt="">
                        <h3>祭祀乘车</h3>
                        <p>当您想来园祭祀亲人时，请提前拨打400-6264-999订车，或者乘坐龙之梦至三岔子的城际公交来园；清明节期间定时定点发车</p>
                    </div>
                </div>
                <div class="shadow">
                    <div class="after-item">
                        <img src="/theme/m2/static/gls/img/index/2.png" alt="">
                        <h3>代理祭祀</h3>
                        <p>可为前来祭祀的人群提供代理祭祀，献花服务。</p>
                    </div>
                </div>
                <div class="shadow">
                    <div class="after-item">
                        <img src="/theme/m2/static/gls/img/index/3.png" alt="">
                        <h3>祭祀提醒</h3>
                        <p>在逝者下葬周年，每年的清明节，中元节（七月十五），寒衣节（十月初一），小年（腊月二十三），除夕（腊月三十）。免费提供祭祀提醒服务</p>
                    </div>
                </div>
                <div class="shadow">
                    <div class="after-item">
                        <img src="/theme/m2/static/gls/img/index/4.png" alt="">
                        <h3>鲜花预定</h3>
                        <p>为您提供网上订购鲜花服务，在5月至9月之间有偿提供鲜花及绢花摆租服务。</p>
                    </div>
                </div>
                <div class="shadow">
                    <div class="after-item">
                        <img src="/theme/m2/static/gls/img/index/5.png" alt="">
                        <h3>合葬服务</h3>
                        <p>在逝者安葬前请提前三天办理二次合葬手续，我园将准备好安葬前的一切工作。</p>
                    </div>
                </div>
                <div class="shadow">
                    <div class="after-item">
                        <img src="/theme/m2/static/gls/img/index/6.png" alt="">
                        <h3>维护登记</h3>
                        <p>您所购墓地石材及绿化所需要维护请电询：4006-264-999</p>
                    </div>
                </div>
            </div>
        </div><!--/wrap-item-->
    </div>
</div>
<script type="text/javascript" src="/theme/m2/static/libs/cSwitch/cSwitch.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.full_slider').cSwitch({
                bigImg : '.slider_main li',
                btnItems : '.btns span',
                PNBtnShow : false,
                changeFade : true,
                changeTime : 3000
            });

            $('.tab').cSwitch({
                btnItems : '.tabtit a',
                bigImg : '.tabcon ul.news_list',
                PNBtnShow : false,
                changeFade : false,
                autoPlay : false
            });

            $.AutoScroll($('.scroll-news'), {
                speed : 1000,
                interval : 5000,
                toStop : true //鼠标移入停止滚动 默认为 false
            });

            (function () {
                var posLeft = [],
                    aTit = $('.process .inner a');

                aTit
                    .each(function (i, ele) {
                        posLeft.push($(ele).position().left);

                        $(ele).hover(
                            function () {
                                $(this).next()
                                    .css('left', posLeft[i] + 'px')
                                    .stop()
                                    .slideDown(function () { $(this).addClass('shadow') });
                            },
                            function () {
                                $(this).next().stop().slideUp(function () { $(this).removeClass('shadow') });
                            } 
                        );
                    })
                    
            })();
            
        });
    </script>