<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\WithdrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '退墓记录';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 withdraw-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [

            'id',
//            'guide_id',
//            'user_id',
            'tomb.tomb_no',
//            'current_tomb_id',
            // 'refund_id',
             'ct_name',
             'ct_mobile',
            // 'ct_card',
             'ct_relation',
             'reson:ntext',
             'price',
            // 'in_tomb_id',
             'note:ntext',
            // 'status',
            // 'updated_at',
            // 'created_at',
//            [
//                'header' => '操作',
//                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{delete}',
//            ]

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>