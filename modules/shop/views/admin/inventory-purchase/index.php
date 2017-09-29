<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\shop\models\InventorySupplier;
use yii\bootstrap\Modal;
\app\assets\JqueryuiAsset::register($this);

$this->title = '进货批次';
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <?php if (Yii::$app->user->can('shop/inventory-purchase/create')):?>
                        <?php
                        $sup = InventorySupplier::find()->where(['status'=>InventorySupplier::STATUS_NORMAL])->select('id')->all();
                        $cnt = count($sup);
                        ?>
                        <?php if ($cnt == 0):?>
                            <?=  Html::a('<i class="fa fa-plus"></i> 进 货', '#', [
                                'class' => 'btn btn-info btn-sm btn-lg',
                                'data-toggle'=>"modal" ,
                                'data-target'=>"#noteModal"
                            ]) ?>
                        <?php else:?>
                            <?=  Html::a('<i class="fa fa-plus"></i> 进 货', ['create'], [
                                'class' => 'btn btn-info btn-sm modalAddButton',
                            ]) ?>
                        <?php endif;?>

                    <?php endif;?>
                    <?php if (Yii::$app->user->can('shop/inventory-supplier/index')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/inventory-supplier/index'])?>">
                            <i class="fa fa-hand-o-right fa-2x"></i>  供货商管理</a>
                    </div>
                    <?php endif;?>
                    <?php if (Yii::$app->user->can('shop/inventory-purchase/refunds')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/inventory-purchase/refunds'])?>">
                            <i class="fa fa-rotate-left fa-2x"></i>  退货管理</a>
                    </div>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <?php
        Modal::begin([
            'header' => '编辑供货商',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
            'size' => Modal::SIZE_LARGE
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '进货',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
            'size' => Modal::SIZE_LARGE
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>


        <?php
        Modal::begin([
            'header' => '进货明细',
            'id' => 'modalView',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
            'size' => Modal::SIZE_LARGE
        ]) ;

        echo '<div id="viewContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 inventory-purchase-index">
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
                'template' => '{update} {refund} {view} {index} {detail}',
                'buttons' => [
                    'refund' => function($url, $model, $key) {
                        return Html::a('退货本批次', $url, ['title' => '退货', 'data-confirm'=>"您确定要进行退货操作吗？","data-method"=>"post"] );
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('修改', $url, ['title' => '修改',
                            'class'=>'modalEditButton',
                            'data-loading-text'=>"页面加载中, 请稍后...",
                            'onclick'=>"return false"
                        ] );
                    },
                    'detail' => function($url, $model, $key) {
                        return Html::a('进货明细', $url, ['title' => '进货明细',
                            'class'=>'modalViewButton',
                            'data-loading-text'=>"页面加载中, 请稍后...",
                            'onclick'=>"return false"
                        ] );
                    },
                    'view' => function($url, $model, $key) {
                        return Html::a('进货
                        ', $url, ['title' => '进货'] );
                    }
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

<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">提示</h4>
            </div>
            <div class="modal-body">
                请先去添加供货商
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <?=Html::a('去添加供货商', Url::toRoute(['/shop/admin/inventory-supplier/index']), ['class'=>'btn btn-primary'])?>
            </div>
        </div>
    </div>
</div>
