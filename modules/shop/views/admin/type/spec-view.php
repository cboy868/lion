<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\core\widgets\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
// use modules\foods\models\Attr;

/* @var $this yii\web\View */
/* @var $model modules\foods\models\Attr */

$this->title = $model->type->title . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '类型列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->type->title . '规格列表', 'url' => ['spec', 'id'=>$model->type_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
    .form-inline .form-group{
        margin-bottom: 20px;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <?php 
            Modal::begin([
                'header' => '添增',
                'id' => 'modalAdd',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12 attr-view">
                <p><strong>规格描述:</strong><?=$model->body?></p>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-xs-6">
                <h4>添加规格值</h4>
                <?= $this->render('_specvform', [
                    'model' => $valmodel,
                ]) ?>
            </div>

            <div class="col-xs-12 attr-val-index">
            <h5>规格值列表</h5>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'val',
            [//todo 这里应该用函数取对应大小的图片
                'label' => '封面',
                'value' => function($model){
                    return $model->getThumb('36x36');
                },
                'format'=>'image'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{spec-update-val} {spec-delete-val}',
                'buttons' => [
                    'spec-update-val' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton'] );
                    },
                    'spec-delete-val' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除', "ria-label"=>"删除", "data-confirm"=>"您确定要删除此项吗？", "data-method"=>"post", "data-pjax"=>"0"] );
                    }
                ],
               'headerOptions' => ['width' => '80']
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>