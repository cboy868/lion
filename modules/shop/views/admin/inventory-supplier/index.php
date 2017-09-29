<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '供货商管理';
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
                    <?php if (Yii::$app->user->can('shop/inventory-supplier/create')):?>


                    <?=  Html::a('<i class="fa fa-plus"></i> 新增',
                            ['create'],
                            [
                                'class' => 'btn btn-primary btn-sm modalAddButton',
                                'data-loading-text'=>"页面加载中, 请稍后...",
                                'onclick'=>"return false"
                            ]) ?>
                    <?php endif;?>

                    <?php if (Yii::$app->user->can('shop/inventory-purchase/index')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/inventory-purchase/index'])?>">
                            <i class="fa fa-cart-plus fa-2x"></i>  进货记录</a>
                    </div>
                    <?php endif;?>
                    <?php if (Yii::$app->user->can('shop/inventory-purchase/refunds')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/inventory-purchase/refunds'])?>">
                            <i class="fa fa-rotate-left fa-2x"></i>  退货记录</a>
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
            'header' => '新增供货商',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
             'size' => Modal::SIZE_LARGE
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

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
            [
                'label' => '联系人',
                'value' => function($model){
                    return $model->ct_name . '(性别:'.$model->sexText .',电话:'.$model->ct_mobile.')';
                }
            ],
            'addr:ntext',
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
            'by.username',
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('shop/inventory-supplier/update'),
                    'view' =>false,
                    'delete' =>Yii::$app->user->can('shop/inventory-supplier/delete'),
                ],
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('修改', $url, ['title' => '修改',
                            'class'=>'modalEditButton',
                            'data-loading-text'=>"页面加载中, 请稍后...",
                            'onclick'=>"return false"
                            ] );
                    }
                ],
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>