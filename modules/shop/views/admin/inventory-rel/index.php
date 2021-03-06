<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\search\InventoryPurchaseRel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '进货明细';
$this->params['breadcrumbs'][] = ['label' => '进货记录', 'url' => ['/shop/admin/inventory-purchase/index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  Html::a($this->title, ['index']) ?> 
                <small>
                    供货商:<?=$record->supplier->cp_name;?>,
                    总金额:<?=$record->total?>
                    供货日期:<?=$record->supply_at?>
                    验收员:<?=$record->checker_name?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 inventory-purchase-rel-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'sku.fullName',
            'unit_price',
            'num',
            'unit',
            'total',
            'retail',
            // 'op_id',
            'op_name',
            'note:ntext',
            'created_at:datetime',
            // 'status',
            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{refund}',
                'buttons' => [
                    'refund' => function($url, $model, $key) {
                        return Html::a('退货', $url, ['title' => '退货', 'data-confirm'=>"您确定要进行退货操作吗？","data-method"=>"post"] );
                    },
                ],
               'headerOptions' => ['width' => '240',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

