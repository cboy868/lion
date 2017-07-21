<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\search\BagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '打包品';
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
                <small>
                    <?php if (Yii::$app->user->can('shop/bag/create')):?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?php endif;?>

                    <?php if (Yii::$app->user->can('shop/goods/index')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/goods/index'])?>">
                            <i class="fa fa-shopping-basket fa-2x"></i>  普通商品管理</a>
                    </div>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 bag-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'label' => '分类',
                'value' => function($data){
                    return $data->category ? $data->category->name : '跨分类';
                }
            ],
            'title',
            'op.username',
            'original_price',
            'price',
            // 'thumb',
            // 'intro:ntext',
            // 'type',
            // 'status',
            // 'created_at',
            // 'updated_at',

            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {view} {rel}',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('shop/bag/update-cate'),
                    'rel' =>Yii::$app->user->can('shop/bag/rel'),
                    'delete' =>Yii::$app->user->can('shop/bag/delete'),
                    'view' =>Yii::$app->user->can('shop/bag/view'),
                ],
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑'] );
                    },
                    'rel' => function($url, $model, $key) {
                        return Html::a('关联商品', $url, ['title' => '关联商品'] );
                    },

                    'view' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看'] );
                    },
                    'delete' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除','aria-label'=>"删除", 'data-confirm'=>"您确定要删除此项吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
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