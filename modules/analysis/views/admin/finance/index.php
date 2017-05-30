<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\analysis\models\SettlementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单统计';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1 style="text-align:right;">
                <small >
                    <?=  Html::a('<i class="fa fa-check"></i> 结账', ['check'], [
                        'class' => 'btn btn-danger btn-lg', 
                        'data-confirm'  =>  '确定要结账吗?',
                        'data-method'   =>  "post",
                        ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 settlement-index">


            <div class="widget-box transparent ui-sortable-handle" id="widget-box-13">
                <div class="widget-header">
                    <div class="">
                        <ul class="nav nav-tabs">
                            <li class="<?php if (!isset($get['today'])): ?>active<?php endif ?>">
                                <a href="<?=Url::toRoute(['index'])?>" aria-expanded="true">全部</a>
                            </li>
                            <li class="<?php if (isset($get['today'])): ?>active<?php endif ?>">
                                <a href="<?=Url::toRoute(['index', 'today'=>1])?>" aria-expanded="true">今日结算</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'order_id',
            'op.username',
            // 'guide_id',
            // 'agent_id',
            'typeLabel',
            'payType',
            'price',
            'intro:ntext',
            'pay_time',
            'settle_time',
            'created_at:datetime',

            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>