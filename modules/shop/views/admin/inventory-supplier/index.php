<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\search\InventorySupplier */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '供货商管理';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 inventory-supplier-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '公司',
                'value' => function($model){
                    return $model->cp_phone ? $model->cp_name . '(' . $model->cp_phone . ')' : $model->cp_name;
                }
            ],
            'addr:ntext',
            [
                'label' => '联系人',
                'value' => function($model){
                    return $model->ct_name . '('.$model->ct_mobile.')';
                }
            ],
            [
                'label' => '其它联系',
                'value' => function($model){
                    $str = '';
                    if ($model->qq) {
                        $str .= 'QQ:' . $model->qq .';';
                    }
                    if ($model->wechat) {
                        $str .= '微信:'.$model->wechat;
                    }

                    return $str;
                },
                'format' =>'raw'
            ],
            'note:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>