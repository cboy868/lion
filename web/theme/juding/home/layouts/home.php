<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
    <meta name="keywords" content="<?=g("keywords")?>" />
    <meta name="description" content="<?=g("description")?>" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?=g("title")?></title>
    <?php $this->head() ?>


    <link rel="stylesheet" href="/theme/juding/static/css/global.css" />
    <link href="/theme/juding/static/css/pageloader.css" rel="stylesheet" type="text/css" media="all" id="pageloader-css" />
    <link rel="stylesheet" type="text/css" href="/theme/juding/static/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="/theme/juding/static/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="/theme/juding/static/css/jquery.jscrollpane.css" />

    <script src="/theme/juding/static/js/jquery-1.11.1.min.js" type="text/javascript" ></script>
    <script src="/theme/juding/static/js/slider.js" type="text/javascript"></script>
    <script src="/theme/juding/static/js/jcarousellite_1.0.1.min.js"  type="text/javascript"></script>
    <script type="text/javascript" src="/theme/juding/static/js/owl.carousel.min.js"></script>

    <script type="text/javascript" src="/theme/juding/static/js/jquery.superslide.2.1.1.js"></script>
</head>

<body>
<?php $this->beginBody() ?>
<link rel="stylesheet" href="/theme/juding/static/css/style.css" />
<script type="text/javascript" src="/theme/juding/static/js/touchslide.js"></script>
<script type="text/javascript" src="/theme/juding/static/js/mobile.index.js"></script>
<script type="text/javascript" src="/theme/juding/static/js/index.js"></script>

<div id="warpper" >
    <div id="header">
        <div class="warp">
            <a class="logo" href="/"><img src="<?=g("logo")?>" style="width:50%;" /></a>
            <a class="menu"><img class="menua" src="/theme/juding/static/picture/menu.png" style="width:50%;"  /></a>
            <a class="menu"><img class="menub" src="/theme/juding/static/picture/menuuu.png" style=" display:none "  /></a>
        </div>
    </div>

    <div id="right">

        <div class="right-c">
            <div class="nei">
                <?php $news_cates = newsCates(null, null);?>
                <ul>
                    <li class="one"><a  href="/" style="background:none !important;">首页</a></li>
                    <li class="one"><a  href="<?=url(['/cms/home/about/us'])?>">关于我们</a></li>

                    <li class="one"><a  href="javascript:;">媒体中心</a></li>
                    <ul class="xia2">
                        <?php foreach ($news_cates as $v):?>
                            <li class="second">
                                <a  href="<?=url(['/news/home/default/index', 'cid'=>$v['id']])?>"><?=$v['name']?></a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                    <li class="one"><a  href="<?=url(['/shop/home/default/index'])?>">产品示</a></li>
                    <li class="one"><a  href="<?=url(['/cms/home/case/index'])?>">成功案例</a></li>
                    <li class="one"><a  href="<?=url(['/cms/home/contact/us'])?>">联系我们</a></li>
                    <li class="one"><a  href="<?=url(['/cms/home/job/us'])?>">人才招聘</a></li>
                </ul>

            </div>
            <div id="footer">
                <div style="margin-top: 1%;width: 100%; text-align:center;">
                    <img src="/theme/juding/static/picture/pel.png" style="width:22px; height:24px;margin-bottom: 4%; ">
                    <span style="color:#aa0001;font-size: 18px;font-weight: 600;"><?=g('hotline')?></span>
                </div>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript">
    TouchSlide({
        slideCell:"#slideBox",
        titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell:".bd ul",
        effect:"leftLoop",
        interTime: 5000,
        delayTime: 500 ,
        autoPage:true,//自动分页
        autoPlay:true //自动播放
    });
</script>
<script type="text/javascript">
    TouchSlide({ slideCell:"#slideBoxs", mainCell:".bds ul", effect:"leftLoop" });
</script>


<!-- 头部 -->

<div class="header">
    <div class="header-show">
        <div class="wrap clearfix">
            <h1 class="blogo fl">
                <a href="/" target="_blank">
                    <img src="<?=g("logo")?>" alt="" />
                </a>
            </h1>
            <div class="headerr fr">
                <div class="headerr-down clearfix">
                    <ul class="pnav fr clearfix">
                        <li>
                            <a href="/" class="head" target="_blank">首页</a>
                        </li>
                        <li >
                            <a href="<?=url(['/cms/home/about/us'])?>" class="head">关于我们 </a>
                        </li>
                        <li >
                            <a href="<?=url(['/news/home/default/index'])?>" class="head">媒体中心</a>
                            <div class="body">
                                <div class="pnav-wrap">
                                    <?php foreach ($news_cates as $v):?>
                                    <a href="<?=url(['/news/home/default/index', 'cid'=>$v['id']])?>" title=""><?=$v['name']?></a>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </li>

                        <li >
                            <a href="<?=url(['/shop/home/default/index'])?>" class="head">产品展示</a>
                        </li>
                        <li >
                            <a href="<?=url(['/cms/home/case/index'])?>" class="head">成功案例</a>
                        </li>
                        <!--
                        <li >
                            <a href="<?=url(['/cms/home/join/us'])?>" class="head"> 加盟</a>
                        </li>
                        -->
                        <li >
                            <a href="<?=url(['/cms/home/contact/us'])?>" class="head">联系我们</a>
                        </li>
                        <li >
                            <a href="<?=url(['/cms/home/job/us'])?>" class="head">人才招聘</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$content?>
<div class="footer">
    <div class="wrap">
        <div class="footer-top clearfix">
            <div class="foot-nav fl">
                <dl>
                    <dt><a href="<?=url(['/cms/home/about/us'])?>">关于我们 </a></dt>
                </dl>
                <dl>
                    <dt><a href="<?=url(['/news/home/default/index'])?>">媒体中心</a></dt>
                    <?php foreach ($news_cates as $v):?>
                    <dd><a href="<?=url(['/news/home/default/index', 'cid'=>$v['id']])?>"><?=$v['name']?></a></dd>
                    <?php endforeach;?>
                </dl>
                <dl>
                    <dt><a href="<?=url(['/shop/home/default/index'])?>">产品展厅</a></dt>
                </dl>
                <!--
                <dl>
                    <dt><a href="<?=url(['/cms/home/join/us'])?>">加盟 </a></dt>

                </dl>
                -->
                <dl>
                    <dt><a href="<?=url(['/cms/home/case/index'])?>">成功案例</a></dt>
                </dl>
                <dl>
                    <dt><a href="<?=url(['/cms/home/job/us'])?>">人才招聘</a></dt>
                </dl>
                <dl class="foot-hot">
                    <dt>
                        全国热线
                    </dt>
                    <dd>
                        <?=g("hotline")?>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="footer-down">
            <p>
                <span style="color:#868585;font-family:FZDBSJW, " line-height:normal;text-align:right;white-space:normal;background-color:#131111;"=""><?=g("reserved")?></span>
            </p>
        </div>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

