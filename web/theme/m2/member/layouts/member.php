<?php
use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="baidu-site-verification" content="sSXyxVj8bS">
    <link rel="stylesheet" href="/theme/m2/static/css/an.css" type="text/css">
    <link rel="stylesheet" href="/theme/m2/static/css/layout.css">
    <link rel="stylesheet" href="/theme/m2/static/css/blog.css">
    <script type="text/javascript" src="/theme/m2/static/libs/jquery1.7.2/jquery.min.js"></script>
</head>


<body>
<?php $this->beginBody() ?>
<div id="site-nav">
    <div id="site-navright">
        <ul>
            <li class="site-myservice">
                <span class="cursor" id="order_pay">待付款<b id="headerCartTotalCount">0</b></span>
                <div id="order-msgcontent" class="comm-drop" style="display:none;">
                    <a href="http://gls.gls024.com/member/order/unpaidlist">
                        <em class="right" style="background:#fee; color:#999;">0</em>待付款</a>
                </div>
            </li>
            <li class="site-go"> <a href="#">去结算</a> </li>
        </ul>
    </div>
    <div id="site-navleft">
        <ul>
            <li class="site-user">
                <a href="/member/index" target="_blank"><?=$user->username?></a>，您好！

                <a href="<?=Url::toRoute(['/admin'])?>" target="_blank">管理中心</a>
                <a href="#" id="signOut">退出</a>
            </li>
            &nbsp;&nbsp;
            <li class="site-help"><a href="javascript:void(0);" class="online-ask qqconsultion">我要帮助</a></li>
            <li class="site-help"><a id="view_opinion1" href="#" target="_blank">客户建议收集</a></li>
        </ul>
    </div>
</div>

<div id="index-header">
    <div id="header">
        <!--
        <a class="logo" href="#">
            <img class="png" src="/theme/m2/static/images/common/logo_03.jpg" alt="">
        </a>
        -->
    </div>
</div>
<div id="nav">
    <div class="container">
        <div class="right">
            <a href="#"><?=$user->username?></a>
            <a href="#" id="signOut">退出</a>
        </div>
        <ul class="clearfix">
            <li class="first"><a href="<?=Url::toRoute(['/'])?>">首页</a></li>
            <li><a href="<?=Url::toRoute(['/news/home/default/index'])?>">资讯</a></li>
            <li><a href="<?=Url::toRoute(['/blog/home/default/index'])?>">服务日志</a></li>
            <li><a href="<?=Url::toRoute(['/memorial/home/default/index'])?>">网上纪念馆</a></li>
        </ul>
    </div>
</div>
<div id="container" class="pad12">
    <div id="app-menu" class="">

        <div id="user-box">
            <a href="#" target="_blank" class="self-avatar">
                <img src="<?=$user->getAvatar('100x100')?>" alt="<?=$user->username?>">
            </a>
            <span class="user-name"><?=$user->username?></span>
            <div class="home-func-box">
                <a href="<?=Url::toRoute(['/user/member/profile/index'])?>" class="my-home home-func" style="font-size:14px;">个人设置</a><br>
                <a href="<?=Url::toRoute(['/user/member/profile/passwd'])?>" class="my-home home-func" style="font-size:14px;">修改密码</a><br>
                <a href="<?=Url::toRoute(['/user/member/profile/avatar'])?>" class="my-home home-func" style="font-size:14px;">修改头像</a><br>
            </div>
        </div>
        <ul id="my-menu">
            <li class="my-blog"><a target="_blank" href="<?=Url::toRoute(['/blog/member/default/index'])?>">我的日志</a>
                <a class="publish" href="<?=Url::toRoute(['/blog/member/default/create'])?>">发表</a></li>
            <li class="my-relative"><a target="_blank" href="<?=Url::toRoute(['/memorial/member/default/index'])?>">纪念馆</a></li>
            <li class="my-order"><a target="_blank" href="<?=Url::toRoute(['/order/member/default/index'])?>">我的订单</a></li>
            <li class="my-task"><a target="_blank" href="<?=Url::toRoute(['/grave/member/ins/index'])?>">碑文确认</a></li>
        </ul>
    </div>
    <?=$content?>
    <div class="clear"></div>
</div>
<!--
<div id="footer" class="cornerb12">
    <p><?=g('fullname')?>客服电话:<?=g("cmobile")?></p>
    <p>传真:<?=g("chuanzhen")?> <?=g("beian")?></p>
</div>
-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
