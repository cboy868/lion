<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
$this->title = '派车列表';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <!--
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div>
        -->
        <!-- /.page-header -->
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

        <?=\app\core\widgets\Alert::widget()?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 car-record-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '墓位',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->tomb->tomb_no, [
                                '/grave/admin/tomb/view',
                                'id'=>$model->tomb_id],['target'=>'_blank']);
                }
            ],
            [
                'label' => '车辆',
                'value' => function($model){
                    return $model->car ? $model->car->code : '';
                }
            ],
            [
                'label' => '司机',
                'value' => function($model){
                    return $model->driver ? $model->driver->username : '';
                }
            ],
             'use_date',
             'use_time',
             'end_time',
             'contact_user',
             'contact_mobile',
             'user_num',
             [
                 'label' => '接盒地点',
                 'value' => function($model) {
                    return $model->address ? $model->address->title : '';
                 }
             ],
             'addr:ntext',
             'note:ntext',
            [
                'label' => '车辆类型',
                'value' => function($model){
                    return $model->carType;
                }
            ],
             'created_at:datetime',
            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {complete} {receive}',
                'buttons' => [
                    'complete' => function($url, $model, $key) {
                        return $model->status == \app\modules\grave\models\CarRecord::STATUS_RECEIVE ? Html::a('确认完成', $url, ['title' => '确认完成', 'class'=>'cmp btn btn-default btn-sm'] ) : '';
                    },
                    'receive' => function($url, $model, $key) {
                        return $model->status == \app\modules\grave\models\CarRecord::STATUS_NORMAL ?
                            Html::a('接收任务', $url, ['title' => '接收任务', 'class'=>'btn btn-default btn-sm modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] ) : '';
                    },
                ],
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>