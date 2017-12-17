<?php
use app\assets\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use app\modules\sys\models\Menu;

use app\modules\grave\models\Tomb;
/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
$menu = Menu::getList();

$current_menu = isset($this->params['current_menu']) ? $this->params['current_menu'] : getFullAction();


$tomb_id = Yii::$app->request->get('tomb_id');
$tomb = Tomb::findOne($tomb_id);
?>
<?php $this->beginPage()?>

<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <?=Html::csrfMetaTags()?>
        
        <title><?=Html::encode($this->title)?> 购墓流程</title>
        <?php $this->head()?>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!--[if lte IE 9]>
            <link rel="stylesheet" href="static/ace/css/ace-part2.min.css" />
        <![endif]-->
        
        <!--[if lte IE 9]>
          <link rel="stylesheet" href="static/ace/css/ace-ie.min.css" />
        <![endif]-->

        <!--[if lte IE 8]>
        <script src="static/ace/js/html5shiv.min.js"></script>
        <script src="static/ace/js/respond.min.js"></script>
        <![endif]-->

    </head>

    <style type="text/css">
        .ace-nav>li {
            /*line-height: 25px;*/
            /*height: 25px;*/
            /*margin-top: 10px;*/
            /*margin-left: 10px;*/
        }
        .panel-heading {
            padding: 10px 10px;
        }
    </style>
    <body class="no-skin">
    <?php $this->beginBody()?>
        <!-- #section:basics/navbar.layout -->
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
                    <a href="<?=Url::toRoute(['/grave/admin/tomb/view', 'id'=>$tomb_id])?>"
                       class="navbar-brand"
                       target="_blank"
                    >
                        【<?=Html::encode($tomb->tomb_no)?>】
                        业务办理
                    </a>
                </div>
                <?php

                    $goods = Yii::$app->params['goods'];
                    $portrait = $goods['cate']['portrait'];
                    $ins = $goods['cate']['ins'];
                 ?>
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">

                        <li class="blue">
                            <a href="<?=Url::toRoute(['/grave/admin/default/index'])?>">
                                返回墓区
                            </a>
                        </li>

                        <li class="grey">
                            <a href="<?=Url::toRoute(['/grave/admin/workbench/index'])?>"
                               target="_blank"
                               >
                                返回工作台
                            </a>
                        </li>

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

                <!--
                <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                        <button class="btn btn-success">
                            <i class="ace-icon fa fa-signal"></i>
                            oa
                        </button>

                        <button class="btn btn-info">
                            <i class="ace-icon fa fa-pencil"></i>
                        </button>

                        <button class="btn btn-warning">
                            <i class="ace-icon fa fa-users"></i>
                        </button>

                        <button class="btn btn-danger">
                            <i class="ace-icon fa fa-cogs"></i>
                        </button>
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="btn btn-success"></span>

                        <span class="btn btn-info"></span>

                        <span class="btn btn-warning"></span>

                        <span class="btn btn-danger"></span>
                    </div>
                </div>
                -->


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
                    <i class="ace-icon fa fa-angle-double-left"
                       data-icon1="ace-icon fa fa-angle-double-left"
                       data-icon2="ace-icon fa fa-angle-double-right"></i>
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

            </div><!-- /.main-content -->

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
    <?php
    Modal::begin([
        'header' => '购买商品',
        'id' => 'modalAdd',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
    ]) ;

    echo '<div id="modalContent"></div>';
    Modal::end();
    ?>
        <!-- basic scripts -->

        <!--[if lte IE 8]>
          <script src="static/ace/js/excanvas.min.js"></script>
        <![endif]-->

        <?php $this->beginBlock('menu') ?>
        $(function(){
            //$('.submenu>.active').parents('.p-menu').addClass('active open');
            //$('#sidebar').addClass('menu-min');
            $('.sidebar-collapse').trigger('click');
        })
        <?php $this->endBlock() ?>
        <?php $this->registerJs($this->blocks['menu'], \yii\web\View::POS_END); ?>


    <?php $this->endBody()?>
    </body>
</html>
<?php $this->endPage()?>
