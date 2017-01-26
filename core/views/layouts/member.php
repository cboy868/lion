<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\MemberAsset;

MemberAsset::register($this);
?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- 
<ul class="bread" style="">
  <li><a href="<?=Url::toRoute(['/member/default/panel'])?>" target="right" class="icon-home"> 首页</a></li>
  <li><a href="##" id="a_leader_txt">个人中心</a></li>
</ul> -->
<?php
echo Breadcrumbs::widget([
	'options' => ['class'=>'bread', 'style'=>'background-color:#f2f9fd;margin-left:0;border-bottom: 1px solid #b5cfd9;'],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'encodeLabels' => false
]);
?><!-- /.breadcrumb -->
<div style="margin:15px;">
<?=$content?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>