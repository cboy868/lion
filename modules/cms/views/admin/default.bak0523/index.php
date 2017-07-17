<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

use yii\bootstrap\Modal;
use app\modules\cms\models\Category;
use app\assets\FootableAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\cms\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $module->name . '内容管理';
$this->params['breadcrumbs'][] = ['label' => '模块管理', 'url' => ['/mod/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;
FootableAsset::register($this);

?>
<style>
    .nc{
        margin-right:10px;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->

    <?php
    Modal::begin([
        'header' => '新增',
        'id' => 'modalAdd',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
        // 'size' => 'modal'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
    ?>

    <?php
    Modal::begin([
        'header' => '编辑',
        'id' => 'modalEdit',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
        // 'size' => 'modal'
    ]) ;

    echo '<div id="editContent"></div>';

    Modal::end();
    ?>

    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=$module->title?>内容管理
                <small>
                    <?php
                    $mod = Yii::$app->request->get('id');
                    ?>
                    <div class="pull-right nc">
                        <a class="btn btn-danger btn-sm" href="<?=Url::toRoute(['/mod/admin/default/index'])?>">
                            <i class="fa fa-th-large fa-2x"></i>  模块管理</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/cms/admin/category/index','mid'=>$module->id])?>">
                            <i class="fa fa-list-ol fa-2x"></i>  分类管理</a>
                    </div>


                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false"
                           href="<?=Url::toRoute(['/cms/admin/default/create', 'type'=>'album', 'mid'=>$module->id])?>">
                            <i class="fa fa-file-text fa-2x"></i>  添加相册</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm"
                           href="<?=Url::toRoute(['/cms/admin/default/create', 'type'=>'post', 'mid'=>$module->id])?>">
                            <i class="fa fa-file-image-o fa-2x"></i>  添加文章</a>
                    </div>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 news-index">

                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="border:none;">
                        <div class="no-border">
                            <ul class="nav nav-tabs">
                                <li class="<?php if($type == 'post'):?>active<?php endif;?>">
                                    <a href="<?=Url::current(['type'=>'post'])?>" aria-expanded="true">文本内容</a>
                                </li>
                                <li class="<?php if($type == 'album'):?>active<?php endif;?>">
                                    <a href="<?=Url::current(['type'=>'album'])?>" aria-expanded="true">图片内容</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                $view = '_' . $type;
                ?>
                <?=$this->render($view,[
                        'dataProvider' => $dataProvider,
                        'type' => $type,
                        'mid' =>$module->id
                ]) ?>

                </div>
            <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>