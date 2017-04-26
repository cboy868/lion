<?php 
use app\assets\WeuiAsset;
use app\core\helpers\Html;
use app\core\helpers\Url;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <title>微信端页面</title>
        <title><?= Html::encode($this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
        <!-- 引入 WeUI -->
        <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
        <link rel="stylesheet" type="text/css" href="/theme/site/static/css/style.css">
        <link rel="stylesheet" type="text/css" href="/theme/site/static/fonts/iconfont.css">
        <link rel="stylesheet" type="text/css" href="/theme/site/static/css/jquery-weui.min.css">
    </head>
    <body>
    <?php $this->beginBody() ?>

        <header class="bar bar-nav">
            <h1 class="title">承德卓迅网络</h1>
            <!-- <a href="http://m.shensuantang.com/ucenter/member/login.html" class="icon pull-right"><i class="sstfont sst-wode"></i></a> -->
        </header>
            
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

            <a href="<?=Url::toRoute('/m/goods')?>" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon"> <i class="sstfont sst-gouwuche"></i> </div>
                <p class="weui-tabbar__label">祭祀</p>
            </a>

            <a href="<?=Url::toRoute('/m/user')?>" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon"> <i class="sstfont sst-geren"></i> </div>
                <p class="weui-tabbar__label">个人中心</p>
            </a>
        </div>

        <script type="text/javascript" src="/theme/site/static/js/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="/theme/site/static/js/swiper.js"></script>

        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>

        <!-- 如果使用了某些拓展插件还需要额外的JS -->
        <!-- <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/swiper.min.js"></script> -->
        <script src="//cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js"></script>

        <script type="text/javascript">
           $(".swiper-container").swiper({
                loop: true,
                autoplay: 3000
              });
        </script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>