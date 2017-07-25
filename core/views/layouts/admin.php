<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use yii\helpers\Url;
use app\modules\sys\models\Menu;

$menu = Menu::getList();


$current_menu = getFullAction();

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <?=Html::csrfMetaTags()?>

        <title><?=Html::encode($this->title)?> 后台管理</title>
        <?php $this->head()?>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!--[if lte IE 9]>
            <link rel="stylesheet" href="/static/ace/css/ace-part2.min.css" />
        <![endif]-->

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="/static/ace/css/ace-ie.min.css" />
        <![endif]-->

        <!--[if lte IE 8]>
        <script src="/static/ace/js/html5shiv.min.js"></script>
        <script src="/static/ace/js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="no-skin">
    <?php $this->beginBody()?>
		<div id="navbar" class="navbar navbar-default">
            <script type="text/javascript">
                try{ace.settings.check('navbar' , 'fixed')}catch(e){}
            </script>

            <div class="navbar-container" id="navbar-container">
                <!-- #section:basics/sidebar.mobile.toggle -->
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
                </button>

                <!-- /section:basics/sidebar.mobile.toggle -->
                <div class="navbar-header pull-left">
                    <!-- #section:basics/navbar.layout.brand -->
                    <a href="#" class="navbar-brand">
                        <small>
                            <i class="fa fa-leaf"></i>
                            LION管理中心
                        </small>
                    </a>

                    <!-- /section:basics/navbar.layout.brand -->

                    <!-- #section:basics/navbar.toggle -->

                    <!-- /section:basics/navbar.toggle -->
                </div>

                <!-- #section:basics/navbar.dropdown -->
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">

                        <li class="blue">
                            <a href="<?=Url::toRoute(['/'])?>" target="_blank">
                                网站前台
                            </a>
                        </li>

                        <li class="green">
                            <a href="<?=Url::toRoute(['/admin/grave/workbench'])?>">
                                工作台
                            </a>
                        </li>

<!--                        <li class="green">-->
<!--                            <a href="--><?//=Url::toRoute(['/grave/admin/default/workbench'])?><!--" target="_blank">-->
<!--                                工作台-->
<!--                            </a>-->
<!--                        </li>-->

                       <!--  <li class="green">
                            <a href="<?=Url::toRoute(['/member'])?>" target="_blank">
                                会员中心
                            </a>
                        </li>  -->

                        <!-- <li class="grey">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-tasks"></i>
                                <span class="badge badge-grey">4</span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-check"></i>
                                    4 Tasks to complete
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">Software Update</span>
                                            <span class="pull-right">65%</span>
                                        </div>

                                        <div class="progress progress-mini">
                                            <div style="width:65%" class="progress-bar"></div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">Hardware Upgrade</span>
                                            <span class="pull-right">35%</span>
                                        </div>

                                        <div class="progress progress-mini">
                                            <div style="width:35%" class="progress-bar progress-bar-danger"></div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">Unit Testing</span>
                                            <span class="pull-right">15%</span>
                                        </div>

                                        <div class="progress progress-mini">
                                            <div style="width:15%" class="progress-bar progress-bar-warning"></div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">Bug Fixes</span>
                                            <span class="pull-right">90%</span>
                                        </div>

                                        <div class="progress progress-mini progress-striped active">
                                            <div style="width:90%" class="progress-bar progress-bar-success"></div>
                                        </div>
                                    </a>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="#">
                                        See tasks with details
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li> -->

                        <!-- <li class="purple">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                                <span class="badge badge-important">8</span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-exclamation-triangle"></i>
                                    8 Notifications
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">
                                                <i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
                                                New Comments
                                            </span>
                                            <span class="pull-right badge badge-info">+12</span>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="btn btn-xs btn-primary fa fa-user"></i>
                                        Bob just signed up as an editor ...
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">
                                                <i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
                                                New Orders
                                            </span>
                                            <span class="pull-right badge badge-success">+8</span>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">
                                                <i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
                                                Followers
                                            </span>
                                            <span class="pull-right badge badge-info">+11</span>
                                        </div>
                                    </a>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="#">
                                        See all notifications
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li> -->

                        <!-- <li class="green">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
                                <span class="badge badge-success">5</span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-envelope-o"></i>
                                    5 Messages
                                </li>

                                <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar">
                                        <li>
                                            <a href="#">
                                                <img src="/static/ace/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Alex:</span>
                                                        Ciao sociis natoque penatibus et auctor ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>a moment ago</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <img src="/static/ace/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Susan:</span>
                                                        Vestibulum id ligula porta felis euismod ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>20 minutes ago</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <img src="/static/ace/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Bob:</span>
                                                        Nullam quis risus eget urna mollis ornare ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>3:15 pm</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <img src="/static/ace/avatars/avatar2.png" class="msg-photo" alt="Kate's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Kate:</span>
                                                        Ciao sociis natoque eget urna mollis ornare ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>1:33 pm</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <img src="/static/ace/avatars/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Fred:</span>
                                                        Vestibulum id penatibus et auctor  ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>10:09 am</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="inbox.html">
                                        See all messages
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li> -->

                        <!-- #section:basics/navbar.user_menu -->
                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="<?=Yii::$app->user->identity->getAvatar('40x40', '/static/images/default.png')?>" alt="Jason's Photo" />
                                <span class="user-info">
                                    <small>Welcome,</small>
                                    <?=Yii::$app->user->identity->username?>
                                </span>

                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>

                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <!-- <li>
                                    <a href="<?=Url::toRoute(['/admin/sys/default/index'])?>">
                                        <i class="ace-icon fa fa-cog"></i>
                                        网站设置
                                    </a>
                                </li> -->

                                <li>
                                    <a href="<?=Url::toRoute(['/member'])?>">
                                        <i class="ace-icon fa fa-user"></i>
                                        会员中心
                                    </a>
                                </li>

                                <li>
                                    <a href="<?=Url::toRoute(['/user/admin/profile/index'])?>" target="_blank">
                                        <i class="ace-icon fa fa-cog"></i>
                                        个人设置
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="<?=Url::toRoute(['/admin/default/logout'])?>" data-method="post">
                                        <i class="ace-icon fa fa-power-off"></i>
                                        登出
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- /section:basics/navbar.user_menu -->
                    </ul>
                </div>

                <!-- /section:basics/navbar.dropdown -->
            </div><!-- /.navbar-container -->
        </div>

        <!-- /section:basics/navbar.layout -->
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>

            <!-- #section:basics/sidebar -->
            <div id="sidebar" class="sidebar responsive">
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){ }
                </script>


                <ul class="nav nav-list">
                    <?php foreach ($menu as $key => $value): ?>
                        <li class="<?php if(isset($value['child'])){echo 'p-menu';}?>">
                            <?php if (isset($value['child'])): ?>
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa <?=$value['icon'] ? $value['icon'] : 'fa-list'?>"></i>
                                    <span class="menu-text"><?=$value['name']?></span>
                                    <b class="arrow fa fa-angle-down"></b>
                                </a>
                            <?php else: ?>
                                <a href="#" class="">
                                    <i class="menu-icon fa <?=$value['icon'] ? $value['icon'] : 'fa-list'?>"></i>
                                    <span class="menu-text"><?=$value['name']?></span>
                                </a>
                            <?php endif ?>
                            <b class="arrow"></b>
                            <?php if (!isset($value['child'])) { continue; } ?>
                            <ul class="submenu">
                                <?php foreach ($value['child'] as $k => $val): ?>
                                    <?php if (!isset($val['child'])): ?>
                                        <?php if (isset($val['url'])): ?>
                                            <li class="<?php if ($val['auth_name'] == $current_menu) { echo 'active'; } ?>" rel="">
                                                <a href="<?=$val['url']?>">
                                                    <i class="menu-icon fa <?=$val['icon']?>"></i>
                                                    <?=$val['name']?>
                                                </a>
                                                <b class="arrow"></b>
                                            </li>
                                        <?php else: ?>
                                            <li class="<?php if ($val['auth_name'] == $current_menu) { echo 'active'; } ?>" rel="">
                                                <a href="#">
                                                    <i class="menu-icon fa <?=$val['icon']?>"></i>
                                                    <?=$val['name']?>
                                                </a>
                                                <b class="arrow"></b>
                                            </li>
                                        <?php endif ?>

                                    <?php else: ?>
                                        <li class="p-menu">
                                            <a href="#" class="dropdown-toggle">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                <?=$val['name']?>
                                                <b class="arrow fa fa-angle-down"></b>
                                            </a>
                                            <b class="arrow"></b>
                                            <ul class="submenu">
                                                <?php foreach ($val['child'] as $k => $last):?>
                                                    <li class="<?php if ($last['auth_name'] == $current_menu) {echo 'active';}?>" rel="<?=$last['auth_name']?>">
                                                        <a href="<?=$last['url'];?>">
                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                           <?=$last['name']?>
                                                        </a>
                                                        <b class="arrow"></b>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </ul>
                        </li>
                    <?php endforeach;?>

                </ul><!-- /.nav-list -->



                <!-- #section:basics/sidebar.layout.minimize -->
                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>

                <!-- /section:basics/sidebar.layout.minimize -->
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){ }
                </script>

                <div style="clear:both;"></div>
            </div>

            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <!-- #section:basics/content.breadcrumbs -->
                <div class="breadcrumbs" id="breadcrumbs">
                    <script type="text/javascript">
                        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                    </script>

<?php
echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'encodeLabels' => false
]);
?><!-- /.breadcrumb -->

                    <!-- #section:basics/content.searchbox -->
                   <!--  <div class="nav-search" id="nav-search">
                        <form class="form-search">
                            <span class="input-icon">
                                <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </form>
                    </div> --><!-- /.nav-search -->

                    <!-- /section:basics/content.searchbox -->
                </div>

                <!-- /section:basics/content.breadcrumbs -->
                <?=$content?>
                <!-- /.page-content -->
            </div><!-- /.main-content -->


            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only fa-3x"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
          <script src="/static/ace/js/excanvas.min.js"></script>
        <![endif]-->
<?php $this->beginBlock('menu') ?>
$(function(){
    $('.submenu>.active').parents('.p-menu').addClass('active open');
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['menu'], \yii\web\View::POS_END); ?>


<div style="clear:both;"></div>
    <!--   <div style="
      position: fixed;
    left: 0px;
    right: 0px;
    width: 100%;
    margin-left: auto;
    margin-right: auto;
    bottom: 10px;">
        <p class="text-center">
           Copyright © 2017-2020 承德卓迅网络科技有限公司 版权所有
        </p>
      </div> -->

       <?php $this->endBody()?>
    </body>
</html>
<?php $this->endPage()?>