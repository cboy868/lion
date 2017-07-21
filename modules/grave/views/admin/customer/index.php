<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\helpers\ArrayHelper;

use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '客户管理';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <!-- <div class="page-header">
            <h1>
                <?=  Html::a($this->title, ['index']) ?> 
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div> -->
        <!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 customer-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'label' => '墓位号',
                'value' => function($model){
                    return '<a href="'.Url::toRoute(['/grave/admin/tomb/view', 'id'=>$model->tomb_id]).'" target="_blank">'.$model->tomb->tomb_no.'</a>';
                },
                'format' => 'raw'
            ],
            'name',
            [
                'label' => '账号',
                'value' => function($model){
                    return $model->user->username;
                }
            ],
            [
                'label' => '地址',
                'value' => function($model) {
                    return $model->address . $model->addr;
                }
            ],
            [
                'label' => '使用人',
                'value' => function($model){
                    $deads = $model->deads;
                    return implode(',', ArrayHelper::getColumn($deads, 'dead_name'));
                }
            ],
            'mobile',
             'email:email',
             'second_ct',
            // 'second_mobile',
            // 'units',
             'relation',
            // 'is_vip',
            // 'vip_desc:ntext',
             'created_at:date',
            // 'updated_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('grave/customer/update'),
                    'view' =>Yii::$app->user->can('grave/customer/view'),
                    'delete' =>Yii::$app->user->can('grave/customer/delete'),
                ],
                ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>