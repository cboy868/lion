<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use yii\helpers\Url;
use app\modules\sys\models\Menu;

$menu = Menu::getList();

$current_menu = isset($this->params['current_menu']) ? $this->params['current_menu'] : getFullAction();


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

                        <li class="grey">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-tasks"></i>

                                <span class="badge badge-grey">快捷链接</span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                                <li class="blue">
                                    <a href="http://www.zhuo-xun.com" target="_blank">
                                        网站前台
                                    </a>
                                </li>

                                <li class="dark">
                                    <a href="http://screen.ibagou.com:8080/?rows=4" target="_blank">
                                        微信大屏
                                    </a>
                                </li>

                                <li class="dark2">
                                    <a href="<?=Url::toRoute(['/memorial/home/site/index'])?>" target="_blank">
                                        纪念馆
                                    </a>
                                </li>

                                <li class="green">
                                    <a href="<?=Url::toRoute(['/admin/grave/workbench'])?>">
                                        工作台
                                    </a>
                                </li>

                            </ul>
                        </li>

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
                                        个人中心
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
                    <style>
                        ul.nav-profile li a{
                            padding: 10px 15px;
                            line-height: 20px;
                        }
                        ul.nav-profile li.active a{
                            background-color: lightseagreen;
                            color: #fff;
                        }
                        ul.nav-profile li a:hover{
                            background-color: lightseagreen;
                            color: #fff;
                        }
                        .page-header{
                            padding-top: 0;
                            padding-bottom: 0;
                        }
                    </style>

                    <?php
                    $profile_nav = $this->params['profile_nav'];
                    ?>
                    <ul class="nav navbar-nav nav-profile">
                        <li class="<?php if($profile_nav == 'user') echo 'active'?>">
                            <a href="<?=Url::toRoute(['/user/admin/profile/index'])?>">
                                个人信息
                            </a>
                        </li>

                        <li class="<?php if($profile_nav == 'task') echo 'active'?>">
                            <a href="<?=Url::toRoute(['/task/admin/profile/index'])?>">
                                任务
                            </a>
                        </li>
                        <li class="<?php if($profile_nav == 'blog') echo 'active'?>">
                            <a href="<?=Url::toRoute(['/blog/admin/profile/index'])?>">
                                博客
                            </a>
                        </li>
                        <li class="<?php if($profile_nav == 'mess') echo 'active'?>">
                            <a href="<?=Url::toRoute(['/mess/admin/profile/index'])?>">
                                食堂
                            </a>
                        </li>
                        <!--
                        <li class="<?php if($profile_nav == 'work') echo 'active'?>">
                            <a href="<?=Url::toRoute(['/approval/admin/profile/work'])?>">
                                考勤
                            </a>
                        </li>
                        <li class="<?php if($profile_nav == 'approval') echo 'active'?>">
                            <a href="<?=Url::toRoute(['/approval/admin/profile/index'])?>">
                                审批
                            </a>
                        </li>
                        -->
                    </ul>


                    <!-- /section:basics/content.searchbox -->
                </div>
                <style>
                    .page-content{
                        /*margin-right:50px;*/
                    }
                    .main-short-btn{
                        padding: 1px 5px;
                        font-size: 6px;
                        font-weight: 400;
                        margin-bottom: 1px;
                    }
                    .main-short-btn .fa-app{
                        margin-bottom: 1px;
                        height:auto;
                        width:48px;
                    }
                    .gotop{
                        /*display: none;*/
                    }
                    .fa-app{
                        display: block;
                        margin-bottom: 5px;
                    }
                    /*.btn img{*/
                        /*height: 48px;*/
                    /*}*/
                    .widget-main .btn-default{
                        border-radius: 5px;
                        margin: 5px;
                        width: 78px;
                    }

                </style>

                <!-- /section:basics/content.breadcrumbs -->
                <?=$content?>
                <!-- /.page-content -->
                <!--
                <div class="main-right-slid" style="width:60px; position: fixed;bottom:100px;right: 0;">
                    <a href="javascript:;" target="_blank" class="btn btn-default main-short-btn gotop" style="display: none">
                        <img src="/static/images/icons/up.png" class="fa-app">
                        Top
                    </a>
                </div>
                -->

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
//    gotop();
//    $(window).scroll(function(){
//        gotop();
//    });
//    $(".main-right-slid .gotop").click(function(){
//        $('html,body').animate({'scrollTop':0},500);
//    });
});

//    function gotop()
//    {
//        if($(window).scrollTop()>120){
//            $(".main-right-slid .gotop").fadeIn();
//        }
//        else{
//            $(".main-right-slid .gotop").fadeOut();
//        }
//    }


    $('#sidebar').addClass('menu-min');
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