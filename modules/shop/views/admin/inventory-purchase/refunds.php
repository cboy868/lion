<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\search\InventoryPurchaseRel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '退货明细';
$this->params['breadcrumbs'][] = ['label' => '进货记录', 'url' => ['/shop/admin/inventory-purchase/index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  $this->title ?> 
                <small>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_refundsearch', ['model' => $searchModel]); ?>
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
            'supplier.cp_name',
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
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

