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
                    <img src="/Resource/Images/v2_top_logo.gif" alt="孝爱网" />
                </a>
            </div>
            <div class="navbar-collapse collapse" role="navigation">
                <ul class="nav navbar-nav">
                    <li class=""><a href="/">主页</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right" style="display:block">
                    <li><a href="<?=Url::toRoute(['/member/default/login'])?>"><i class="navIcon user"></i>登录</a></li>
                    <li><a href="<?=Url::toRoute(['/member/default/reg'])?>"><i class="navIcon register"></i>注册</a></li>
                </ul>
                <ul class="list-inline jlg-user" style="display:none">
                    <li><a href="#"><p title="进入我的博客中心"></p></a></li>
                    <li><a href="/member"><p><strong>进入个人中心</strong></p></a></li>
                    <li><a href="/Account/LoginOut"><p>退出</p></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="blank"></div>

<?=$content?>

<div class="mainfooter zx-footer">
    <div class="container">
        <div class="">
            <div class="col-md-10">
                <div class="row">
                    <ul class="list-inline">
                        <li><a href="#">关于我们</a></li>
                        <li><a href="#">联系我们</a></li>
                    </ul>

                </div>
            </div>
            <div class="col-md-2">
                <div class="row attention">
                    <div class="col-md-12 col-sm-4 col-xs-4">
                        <img width="150" src="/static/images/ma1.jpg" />
                        <p>关注微信平台</p>
                    </div>
                </div>
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