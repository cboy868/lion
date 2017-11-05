<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\order\models\Order;
Yii::$app->params['cur_nav'] = 'order_index';
$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 order-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        'columns' => [
            [
                'label' => '关联墓位',
                'value' => function($model){
                    $tomb = $model->tomb ? $model->tomb->tomb_no : '';
                    if ($tomb) {
                        return Html::a($tomb, ['/grave/member/tomb/tomb', 'id'=>$model->tomb->id], ['target'=>'_blank']);
                    }
                },
                'format'=>'raw'
            ],
            // 'wechat_uid',
            'op.username',

            // 'type',
            // 'progress',

            [
                'label' => '项目',
                'value' => function($model) {
                    $rels = $model->rels;
                    return implode('+', \yii\helpers\ArrayHelper::getColumn($rels, 'title'));
                }
            ],
            'price',
            [
                'label'=> '支付进度',
                'value' => function($data){
                    return Order::pro($data->progress);
                }
            ],
            // 'note:ntext',
            'created_at:datetime',
            // 'updated_at',
            // 'status',

            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{view} ',
               'headerOptions' => ['width' => '100',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>