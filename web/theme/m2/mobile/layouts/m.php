<?php 

use app\core\helpers\Html;
use app\core\helpers\Url;


\app\assets\VueAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title><?=g("cp_name")?></title>
        <title><?= Html::encode($this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
        <!-- 引入 WeUI -->
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" type="text/css" href="/theme/m2/static/mobile/style.css">
        <link rel="stylesheet" type="text/css" href="/theme/m2/static/mobile/fonts/iconfont.css">
        <link rel="stylesheet" type="text/css" href="/theme/m2/static/mobile/jquery-weui.min.css">
    </head>
    <body>
    <?php $this->beginBody() ?>

        <!-- <header class="bar bar-nav">
            <h1 class="title"><?=g("cp_name")?></h1>
        </header> -->
        <?=$content?>
        <div class="weui-tabbar">
            <a href="<?=Url::toRoute('/m')?>" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon"> <i class="sstfont sst-shouye"></i> </div>
                <p class="weui-tabbar__label">首 页</p>
            </a>

            <a href="<?=Url::toRoute('/m/news')?>" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon"> <i class="sstfont sst-liebiao"></i> </div>
                <p class="weui-tabbar__label">新闻资讯</p>
            </a>

            <a href="<?=Url::toRoute('/m/products')?>" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon"> <i class="sstfont sst-gouwuche"></i> </div>
                <p class="weui-tabbar__label">祭祀</p>
            </a>

            <!--
            <a href="<?=Url::toRoute('/m/user')?>" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon"> <i class="sstfont sst-geren"></i> </div>
                <p class="weui-tabbar__label">个人中心</p>
            </a>
            -->
        </div>

        <script type="text/javascript" src="/theme/site/static/js/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="/theme/site/static/js/swiper.js"></script>

        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js"></script>

        <script type="text/javascript">
           // $(".swiper-container").swiper({
           //      loop: true,
           //      autoplay: 3000
           //    });
        </script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>