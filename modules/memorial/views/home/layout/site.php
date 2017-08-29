<?php
use yii\helpers\Html;
use yii\helpers\Url;
\app\modules\memorial\assets\SiteAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="wb:webmaster" content="2fdbdc90adf3258f">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="keywords" content="">
    <meta name="Description" content="">
    <meta name="Author" content="">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head()?>
</head>

<body>
<?php $this->beginBody() ?>
<style>
    .navbar{
        min-height:auto;
    }
</style>
<div class="navbar navbar-default ">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-md hidden-lg" href="/">
                    <img src="<?=g('logo')?>" alt="<?=g('cp_name')?>" />
                </a>
            </div>
            <div class="navbar-collapse collapse" role="navigation">
                <?php $cnav = isset($this->params['current_nav']) ? $this->params['current_nav'] : ''?>
                <ul class="nav navbar-nav">
                    <li class=""><a href="/">门户主页</a></li>
                    <li class="<?php if($cnav == 'index')echo 'active'?>"><a href="<?=Url::toRoute(['/memorial/home/site/index'])?>">首页</a></li>
                    <li class="<?php if($cnav == 'memorial')echo 'active'?>"><a href="<?=Url::toRoute(['/memorial/home/site/memorial'])?>">纪念馆</a></li>
                    <!--                    <li><a href="--><?//=Url::toRoute(['/memorial/home/site/days'])?><!--">生忌</a></li>-->
                    <li class="<?php if($cnav == 'miss')echo 'active'?>"><a href="<?=Url::toRoute(['/memorial/home/site/miss'])?>">追思文章</a></li>
                    <li class="<?php if($cnav == 'album')echo 'active'?>"><a href="<?=Url::toRoute(['/memorial/home/site/album'])?>">音容笑貌</a></li>
                </ul>
                <?php if (Yii::$app->user->isGuest):?>
                <ul class="nav navbar-nav navbar-right" style="display:block">
                    <li><a href="<?=Url::toRoute(['/member/default/login'])?>"><i class="navIcon user"></i>登录</a></li>
                    <li><a href="<?=Url::toRoute(['/member/default/reg'])?>"><i class="navIcon register"></i>注册</a></li>
                </ul>
                <?php else:?>
                <ul class="list-inline jlg-user">
                    <li><a href="#"><p title="进入我的博客中心"></p></a></li>
                    <li><a href="/member"><p><strong>进入个人中心</strong></p></a></li>
                    <li><a href="<?=Url::toRoute(['/member/default/logout'])?>" data-method="post" class="logout"><p>退出</p></a></li>
                </ul>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<style>
    .main-container{
        height: auto;
        margin: 0 auto;
        padding: 12px 18px 0 24px;
        background: rgba(255,255,255,0.95);
        position: relative;
    }
</style>
<div class="blank"></div>
    <?=$content?>

<div class="mainfooter zx-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="text-align: center;">
                <p>
                    <?=g("reserved")?> <?=g('beian')?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php $this->beginBlock('tree') ?>

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage()?>