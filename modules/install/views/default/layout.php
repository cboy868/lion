<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
    /*.container {width: auto;max-width: 980px;padding-top: 40px;}*/
    html,body{font-size:13px;font-family:"Microsoft YaHei UI", "微软雅黑", "宋体";}
    .pager li.previous a{margin-right:10px;}
    .header a{color:#FFF;}
    .header a:hover{color:#428bca;}
    .footer{padding:10px;}
    .footer a,.footer{color:#eee;font-size:14px;line-height:25px;}
  </style>
</head>
<body style="background-color:#28b0e4;">
<?php $this->beginBody() ?>
<div class="container">
    <div class="header" style="margin:15px auto;">
        <ul class="nav nav-pills pull-right" role="tablist">
            <li role="presentation"><a href="http://www.zhuo-xun.com" target="_blank">卓迅官网</a></li>
        </ul>
        <img src="/static/images/default_trans.png" style="height: 100px;">
    </div>

	<?=$content?>
    <div class="footer" style="margin:15px auto;">
        <div class="text-center">
            <a href="http://www.zhuo-xun.com/" target="_blank">帮助</a> &nbsp; &nbsp;
            <a href="http://www.zhuo-xun.com/" target="_blank">商业授权</a>
        </div>
        <div class="text-center">
            Powered by
            <a href="http://www.zhuo-xun.com/" target="_blank"><b>卓迅</b></a> v0.1 © 2017
            <a href="http://www.zhuo-xun.com/" target="_blank">www.zhuo-xun.com</a>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



