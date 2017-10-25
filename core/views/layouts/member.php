<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\MemberAsset;
use yii\helpers\Url;

MemberAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <?=Html::csrfMetaTags()?>

        <title><?=Html::encode($this->title)?> 卓迅系统会员中心</title>
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
                        会员中心
                    </small>
                </a>

            </div>

            <!-- #section:basics/navbar.dropdown -->
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">


                    <li class="blue">
                        <a href="<?=Url::toRoute(['/'])?>" target="_blank">
                            网站首页
                        </a>
                    </li>

                    <li class="green">
                        <a href="<?=Url::toRoute(['/memorial/home/site/index'])?>" target="_blank">
                            纪念馆主页
                        </a>
                    </li>


                    <!-- #section:basics/navbar.user_menu -->
                    <li class="light-blue">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <img class="nav-user-photo" src="<?=Yii::$app->user->identity->getAvatar('40x40', '/static/images/default.png')?>" alt="Jason's Photo" />
                            <span class="user-info">
                                    <small>欢迎</small>
                                <?=Yii::$app->user->identity->username?>
                                </span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>



                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="<?=Url::toRoute(['/user/member/profile/index'])?>" target="_blank">
                                    <i class="ace-icon fa fa-cog"></i>
                                    个人设置
                                </a>
                            </li>

                            <li>
                                <a href="<?=Url::toRoute(['/user/member/profile/passwd'])?>" target="_blank">
                                    <i class="ace-icon fa fa-cog"></i>
                                    修改密码
                                </a>
                            </li>

                            <li>
                                <a href="<?=Url::toRoute(['/user/member/profile/avatar'])?>" target="_blank">
                                    <i class="ace-icon fa fa-cog"></i>
                                    修改头像
                                </a>
                            </li>
                            <li class="divider"></li>

                            <li>
                                <a href="<?=Url::toRoute(['/member/default/logout'])?>" data-method="post">
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


            <?php

            $cur_nav = isset(Yii::$app->params['cur_nav']) ? Yii::$app->params['cur_nav'] : '';
            ?>
            <ul class="nav nav-list">
                <li class="p-menu <?php if($cur_nav == 'member_index')echo'active';?>" rel="">
                    <a href="<?=Url::toRoute(['/member/default/index'])?>">
                        <i class="menu-icon fa fa-user"></i>
                        会员首页
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="p-menu hsub">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa fa-mortar-board"></i>
                        <span class="menu-text">纪念馆管理</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="<?php if($cur_nav == 'memorial_index')echo'active';?>" rel="">
                            <a href="<?=Url::toRoute(['/memorial/member/default/index'])?>">
                                我创建的
                            </a>
                            <b class="arrow"></b>
                        </li>
<!--
                        <li class="" rel="">
                            <a href="#">
                                我的关注
                            </a>
                            <b class="arrow"></b>
                        </li>
-->
                        <li class="<?php if($cur_nav == 'memorial_create')echo'active';?>" rel="">
                            <a href="<?=Url::toRoute(['/memorial/member/default/create'])?>">
                                创建新馆
                            </a>
                            <b class="arrow"></b>
                        </li>

                    </ul>
                </li>

                <li class="p-menu hsub">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa fa-bar-chart"></i>
                        <span class="menu-text">业务管理</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="<?php if($cur_nav == 'tomb_index')echo'active';?>" rel="">
                            <a href="<?=Url::toRoute(['/grave/member/tomb/index'])?>">
                                购买的墓位
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="<?php if($cur_nav == 'order_index')echo'active';?>" rel="">
                            <a href="<?=Url::toRoute(['/order/member/default/index'])?>">
                                订单记录
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="p-menu hsub">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa fa-th-large"></i>
                        <span class="menu-text">博客管理</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="<?php if($cur_nav == 'blog_index')echo'active';?>" rel="">
                            <a href="<?=Url::toRoute(['/blog/member/default/index'])?>">
                                博客
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="<?php if($cur_nav == 'album_index')echo'active';?>" rel="">
                            <a href="<?=Url::toRoute(['/blog/member/album/index'])?>">
                                相册
                            </a>
                            <b class="arrow"></b>
                        </li>

                    </ul>
                </li>
                <li class="p-menu hsub">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa fa-th-large"></i>
                        <span class="menu-text">我的审批</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="<?php if($cur_nav == 'approval_index')echo'active';?>" rel="">
                            <a href="<?=Url::toRoute(['/approval/member/default/index'])?>">
                                我提交的
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="<?php if($cur_nav == 'approval_pi')echo'active';?>" rel="">
                            <a href="<?=Url::toRoute(['/approval/member/default/pi'])?>">
                                待您审批
                            </a>
                            <b class="arrow"></b>
                        </li>

                    </ul>
                </li>
            </ul>

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

                <!-- /section:basics/content.searchbox -->
            </div>

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
    <?php $this->endBody()?>
    </body>
    </html>
<?php $this->endPage()?>