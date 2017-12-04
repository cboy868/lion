<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '库存';
$this->params['breadcrumbs'][] = ['label' => '食堂', 'url' => ['/mess/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;

\app\assets\JqueryuiAsset::register($this);
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= $this->title ?>

                <small>
                    <div class="pull-right nc">
                        <a class="btn btn-default btn-sm" href="<?=Url::toRoute(['/mess/admin/default/index'])?>">
                            <i class="fa fa-cog fa-2x"></i>  食堂基础设置</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-default btn-sm" href="<?=Url::toRoute(['/mess/admin/storage/index'])?>">
                            <i class="fa fa-server fa-2x"></i>  库存记录</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/mess/admin/day/index'])?>">
                            <i class="fa fa-list fa-2x"></i>  菜单安排制作</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/mess/admin/panel/index'])?>">
                            <i class="fa fa-puzzle-piece fa-2x"></i>  厨师操作台</a>
                    </div>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search_storage', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 mess-storage-record-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'mess.name',
            'food.food_name',
            'num',
            // 'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} ',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );
                    }
                ],
                'headerOptions' => ['width' => '80',"data-type"=>"html"]
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>