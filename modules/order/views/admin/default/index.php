<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\order\models\Order;

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
            'id',
            [
                'label' => '关联墓位',
                'value' => function($model){
                    $tomb = $model->tomb ? $model->tomb->tomb_no : '';
                    return Html::a($tomb, ['/grave/admin/tomb/view', 'id'=>$model->tid], ['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            // 'wechat_uid',
            'user.username',
            'op.username',

            // 'type',
            // 'progress',

            [
                'label' => '项目',
                'value' => function($model) {
                    $rels = $model->rels;
                    $items = implode('+', \yii\helpers\ArrayHelper::getColumn($rels, 'title'));
                    return Html::a($items, ['view', 'id'=>$model->id]);
                },
                'format' => 'raw'
            ],
            'price',
            'origin_price',
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
                'template' => '{delete} {view} {refund}',
                'visibleButtons' =>[
                    'view' =>Yii::$app->user->can('order/default/view'),
                    'delete' =>Yii::$app->user->can('order/default/delete'),
                    'refund' =>Yii::$app->user->can('order/default/refund'),
                ],
                'buttons' => [
                    'delete' => function($url, $model, $key) {
                        return Html::a(' <span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除','aria-label'=>"删除", 'data-confirm'=>"您确定要删除此项吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                    },
                    'view' => function($url, $model, $key) {
                        return Html::a(' <span class="glyphicon glyphicon glyphicon-eye-open"></span>查看详情', $url,
                            ['title' => '查看', 'data-pjax'=>"0"] );
                    },

                    'refund' => function($url, $model, $key) {
                        if (($model->progress >= Order::PRO_PART || $model->progress == Order::PRO_REFUND_PART)
                            && $model->progress != Order::PRO_DELAY) {
                            return Html::a('退款', $url, ['title' => '退款处理','aria-label'=>"退款处理"] );
                        }

                        return '';
                        
                    },

                ],
               'headerOptions' => ['width' => '120',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>