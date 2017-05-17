<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\cms\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '模块列表';
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
                    <a href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm modalAddButton' title="添加模块"
                       data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加模块</a>
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

            <div class="col-xs-12 category-index">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                         [
                             'label' => '模块名',
                             'value' => function($model){
                                return '<img src="'.$model->getThumbImg('36x36').'"> ' . $model->name;
                             },
                             'format' => 'raw'
                         ],
//                        [
//                            'label' => '模型id',
//                            'value' => function($model){
//                                return $model->res_name;
//                            }
//                        ],
                         'body:ntext',
                        // 'sort',
                        // 'seo_title',
                        // 'seo_keywords',
                        // 'seo_description:ntext',
                         'created_at:datetime',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=>'操作',
                            'template' => '{update} {delete} {view} {info}',
                            'buttons' => [
                                'update' => function($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );
                                },
                                'view' => function($url, $model, $key) {
                                    return Html::a('分类管理', $url, ['title' => '编辑'] );
                                },
                                'info' => function($url, $model, $key) {
                                    $url = Url::toRoute(['/cms/admin/default/index', 'id'=>$model->id]);
                                    return Html::a('内容管理', $url, [
                                        'title' => '内容管理']);
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