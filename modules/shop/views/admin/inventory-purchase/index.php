<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\search\InventoryPurchase */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '进货入库';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 进 货', ['create'], ['class' => 'btn btn-info btn-sm']) ?>
                    <?=  Html::a('退货记录', ['refunds'], ['class' => 'btn btn-info btn-sm']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-6 inventory-purchase-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'supplier.cp_name',
            // 'op_id',
            'op_name',
            [
                'label' => '联系人',
                'value' => function($model){
                    return $model->ct_name . '('.$model->ct_mobile.')';
                }
            ],
            // 'checker_id',
            'checker_name',
            'total',
            'note:ntext',
            'supply_at',
            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {refund} {view} {index}',
                'buttons' => [
                    'index' => function($url, $model, $key) {
                        $uri = Url::toRoute(['index', 'id'=>$model->id]);
                        return Html::a('商品进货明细', $uri);
                    },
                    'refund' => function($url, $model, $key) {
                        return Html::a('退货本批次', $url, ['title' => '退货', 'data-confirm'=>"您确定要进行退货操作吗？","data-method"=>"post"] );
                    },
                ],
               'headerOptions' => ['width' => '240',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

<div class="col-xs-6 inventory-purchase-rel-index">
<?php if (isset($rel_dataProvider) && $rel_dataProvider->getModels()): ?>
    <div class="search-box search-outline">
    <h3>进货明细</h3>
           <small>
                供货商:<?=$record->supplier->cp_name;?>,
                总金额:<?=$record->total?>
                供货日期:<?=$record->supply_at?>
                验收员:<?=$record->checker_name?>
            </small>

    </div>
    <div class="search-box search-outline">
                        <?php  echo $this->render('_relsearch', ['model' => $rel_searchModel]); ?>
                </div>

    <?= GridView::widget([
        'dataProvider' => $rel_dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
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
                'template' => '{rel-refund}',
                'buttons' => [
                    'rel-refund' => function($url, $model, $key) {
                        return Html::a('退货', $url, ['title' => '退货', 'data-confirm'=>"您确定要进行退货操作吗？","data-method"=>"post"] );
                    },
                ],
               'headerOptions' => ['width' => '80',"data-type"=>"html"]
            ]
        ],
    ]); ?>
<?php endif ?>

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>