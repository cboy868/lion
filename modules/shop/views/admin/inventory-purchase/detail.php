<?php

use app\core\helpers\Html;
use app\core\widgets\GridView;

?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">

<div class="col-xs-12 inventory-purchase-rel-index">
<?php if (isset($rel_dataProvider) && $rel_dataProvider->getModels()): ?>
    <div class="search-box search-outline">
           <small>
                供货商:<?=$record->supplier->cp_name;?>,
                总金额:<?=$record->total?>
                供货日期:<?=$record->supply_at?>
                验收员:<?=$record->checker_name?>
            </small>

    </div>
    <!--
    <div class="search-box search-outline">
                        <?php  //echo $this->render('_relsearch', ['model' => $rel_searchModel]); ?>
                </div>
-->
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
                'visibleButtons' =>[
                    'rel-refund' =>Yii::$app->user->can('shop/inventory-purchase/rel-refund'),
                ],
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
