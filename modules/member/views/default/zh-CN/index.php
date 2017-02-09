<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\MemberAsset;
use app\modules\member\models\Member;

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

<body style="background-color:#f2f9fd;">
<?php $this->beginBody() ?>

<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="<?=Member::getAvatar()?>" class="radius-circle rotate-hover" height="50" alt="" />会员中心</h1>
  </div>
  <div class="head-l float-right button-group">
    <a class="button button-little bg-green" href="<?=Url::toRoute(['/'])?>" target="_blank"><span class="icon-home"></span> 网站首页</a> &nbsp;&nbsp;
    <!-- <a href="##" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp; -->
    <?php if (Yii::$app->user->identity->is_staff): ?>
      <a class="button button-little bg-blue" href="<?=Url::toRoute(['/admin'])?>" data-method="post"> 管理中心</a> 
    <?php endif ?>
    <a class="button button-little bg-red" href="<?=Url::toRoute(['default/logout'])?>" data-method="post"><span class="icon-power-off"></span> 退出登录</a> 
  </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
  <h2><span class="icon-user"></span>个人中心</h2>
  <ul style="display:block">
    <li><a href="<?=Url::toRoute(['/member/default/panel'])?>" target="right"><span class="icon-caret-right"></span>操作面板</a></li>
    <li><a href="<?=Url::toRoute(['/member/user/profile/index'])?>" target="right"><span class="icon-caret-right"></span>我的设置</a></li>
    <!-- <li><a href="info.html" target="right"><span class="icon-caret-right"></span>我的文章</a></li> -->
    <!-- <li><a href="pass.html" target="right"><span class="icon-caret-right"></span>我的图集</a></li> -->
    <li><a href="<?=Url::toRoute(['/member/cms/favor/index'])?>" target="right"><span class="icon-caret-right"></span>我的收藏</a></li>  
    <!-- <li><a href="book.html" target="right"><span class="icon-caret-right"></span>留言管理</a></li>      -->
    <!-- <li><a href="column.html" target="right"><span class="icon-caret-right"></span>查看历史记录</a></li>

    <li>
      <a href="<?=Url::toRoute(['/member/memorial'])?>" target="right" class="float-left" target="right"><span class="icon-caret-right"></span>纪念馆</a> 
      <a href="<?=Url::toRoute(['/member/memorial/default/create'])?>" class="float-right" style="margin-right:20px;" target="right">添加</a>
    </li> -->
  </ul>   
  <!-- <h2><span class="icon-pencil-square-o"></span>栏目管理</h2>
  <ul>
    <li><a href="list.html" target="right"><span class="icon-caret-right"></span>内容管理</a></li>
    <li><a href="add.html" target="right"><span class="icon-caret-right"></span>添加内容</a></li>
    <li><a href="cate.html" target="right"><span class="icon-caret-right"></span>分类管理</a></li>        
  </ul>   -->
</div>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="<?=Url::toRoute(['/member/default/panel'])?>" name="right" width="100%" height="100%"></iframe>
</div>
<?php $this->beginBlock('nav') ?>
$(function(){
  $(".leftnav h2").click(function(){
      $(this).next().slideToggle(200);  
      $(this).toggleClass("on"); 
  })
  $(".leftnav ul li a").click(function(){
        //$("#a_leader_txt").text($(this).text());
        $(".leftnav ul li a").removeClass("on");
        $(this).addClass("on");
  })
});
<?php $this->endBlock('nav') ?>
<?php $this->registerJs($this->blocks['nav'], \yii\web\View::POS_END); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>