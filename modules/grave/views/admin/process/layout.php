<?php
use app\assets\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;


use app\modules\grave\models\Tomb;
/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);

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
            line-height: 25px;
            height: 25px;
            margin-top: 10px;
            margin-left: 10px;
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
                    <a href="#" class="navbar-brand">
                        业务办理流程
                        <small>
                            <?=Html::encode($this->title)?>
                        </small>
                    </a>


                    <!-- /section:basics/navbar.layout.brand -->

                    <!-- #section:basics/navbar.toggle -->

                    <!-- /section:basics/navbar.toggle -->
                </div>

                <!-- #section:basics/navbar.dropdown -->

                <?php 

                    $goods = Yii::$app->params['goods'];
                    $portrait = $goods['cate']['portrait'];
                    $ins = $goods['cate']['ins'];
                    $tomb_id = Yii::$app->request->get('tomb_id');

                    $tomb = Tomb::findOne($tomb_id);


                 ?>
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">

                        <li class="green">
                            <a href="<?=Url::toRoute(['/grave/admin/mall/index', 'tomb_id'=>$tomb_id])?>" class="modalAddButton" target="_blank" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                                购买商品
                            </a>
                        </li> 

                        <?php if (!$tomb->hasIns()): ?>
                            <li class="blue">
                                <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$ins, 'tomb_id'=>$tomb_id])?>" class="modalAddButton" target="_blank" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                                    购买墓碑
                                </a>
                            </li> 
                        <?php endif ?>

                        <li class="green">
                            <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$portrait, 'tomb_id'=>$tomb_id])?>" class="modalAddButton" target="_blank" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                                购买瓷像
                            </a>
                        </li> 

                        <li class="grey">
                            <a href="<?=Url::toRoute(['/grave/admin/tomb/view', 'id'=>$tomb_id])?>" target="_blank">
                                一墓一档
                            </a>
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

                <!-- /section:basics/sidebar.layout.minimize -->
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){ }
                </script>

                <div style="clear:both;"></div>
            </div>

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


            <!-- /section:basics/sidebar -->
            <!-- <div class="main-content"> -->

                <!-- #section:basics/content.breadcrumbs -->
               

                <!-- /section:basics/content.breadcrumbs -->
                <?=$content?>
                <!-- /.page-content -->
            <!-- </div> -->
            <!-- /.main-content -->


            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->


        <!--[if lte IE 8]>
          <script src="static/ace/js/excanvas.min.js"></script>
        <![endif]-->

       <?php $this->endBody()?>
    </body>
</html>
<?php $this->endPage()?>
