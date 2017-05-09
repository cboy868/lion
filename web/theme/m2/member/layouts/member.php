<?php
use yii\helpers\Html;
use yii\helpers\Url;

//$action = Yii::$app->controller->action->id;
$navs = \app\modules\cms\models\Nav::navs();

$controller = Yii::$app->controller;
$controller_id = $controller->id;
$module_id = $controller->module->id;
$action_id = $controller->action->id;

$c_nav = '/'.$module_id .'/'. $controller_id .'/'. $action_id;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/global.css">

    <script type="text/javascript" src="/theme/m2/static/libs/jquery1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="/theme/m2/static/gls/js/global.js"></script>
</head>

<body>
<?php $this->beginBody() ?>
    <div id="site-nav">
        <div id="site-navright">
            <div style="width:90px;height:32px;float:right;" id="site-navright">
                <ul>
                    <li style="width:90px;height:32px;float:right;" class="site-memorial"><a href="/">网站首页</a></li>
                </ul>
            </div>              
        </div>
        <div id="site-navleft">
            <ul>
            <li><a href='/login'>注册/登录</a></li>
             <li class="site-help"><a class="online-ask qqconsultion" href="javascript:void(0);">我要帮助</a></li>
                <li class="site-help"><a target="_blank" href="/notice/addnotice" id="view_opinion1">客户建议收集</a></li>
            </ul>
        </div>
    </div>
    <div class="header">
        <div class="container posf">
            <a href="/page" class="logo" title="<?=g("cp_name")?>">
                <img src="<?=g('logo')?>" alt="logo">
            </a>
            <span class="wechat">
<!--                <img src="/theme/m2/static/gls/img/global/wechat.gif" alt="wechat">-->
            </span>
<!--            <img class="flower" src="/theme/m2/static/gls/img/global/head_flower.png" alt="">-->
        </div>
    </div>
    <div class="nav">
        <div class="container">
            <div class="right">
                <a href="#">登录</a>
                <span> | </span>
                <a href="#">注册</a>
            </div>
            <ul>
                <?php foreach ($navs as $k => $v):?>
                <li><a href="<?=Url::toRoute($v['url'])?>" class="<?php if($c_nav == $v['url']):?>active<?php endif;?>"><?=$v['name']?></a></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <?=$content?>
    <div class="footer">
        <div class="container">
            <p><?=g("fullname")?>客服电话:<?=g("cmobile")?></p>
            <p>传真:<?=g("chuanzhen")?>  <?=g("beian")?></p>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
