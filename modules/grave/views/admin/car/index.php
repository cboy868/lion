<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '车辆管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <a href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm modalAddButton' title="添加新车辆"
                       data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加新车辆</a>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '新增',
            'id' => 'modalAdd',
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '编辑',
            'id' => 'modalEdit',
            // 'size' => 'modal'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 car-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
//            'id',
//            'code',
            [
                'label' => '车牌号',
                'value' => function($model){
                    return $model->code;
                },
                'headerOptions' => ['width'=>'100'],
            ],
            [
                'label' => '车辆类型',
                'value' => function($model){
                    return $model->carType;
                },
                'headerOptions' => ['width'=>'150'],
            ],
//            'carType',
//            'keeper',
            'note:ntext',
            // 'status',
            // 'created_at',
            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );
                    }
                ],
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>