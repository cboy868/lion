<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\focus\models\FocusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '焦点图';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-xs modalAddButton']) ?>

                    <?=  Html::a('<i class="fa fa-chevron-circle-right"></i> 焦点图分类', ['admin/category/index'], ['class' => 'btn btn-primary btn-large pull-right']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

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
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 focus-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            // 'id',
            'category_id',
            [
                'label' => '分类',
                'value' => function($data){
                    return $data->category->title;
                }
            ],
            'title',
            'link',
            [
                'label' => '图片',
                'value' => function($data){
                    return '<img src="'.$data->getImg('100x50').'" alt="">';
                },
                'format' => 'raw'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '修改', 'class'=>'modalEditButton'] ) ;
                    },
                ],
               'headerOptions' => ['width' => '180']
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>