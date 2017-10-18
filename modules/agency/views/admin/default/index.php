<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;


$this->title = '办事处管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <a href="<?=Url::to(['create'])?>"
                       class='btn btn-primary btn-sm modalAddButton' title="添加分类"
                       data-loading-text="页面加载中, 请稍后..." onclick="return false">
                        <i class="fa fa-plus"></i>新增办事处
                    </a>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '添增',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
             'size' => 'modal-lg'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '编辑',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
            'size' => 'modal-lg'
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

            <div class="col-xs-12 agency-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'title',
            [
                'label'=>'负责人',
                'value' => function($model){
                    $str = '';
                    if ($model->mobile) {
                        $str = '('.$model->mobile.')';
                    }
                    return $model->lUser->username . $str;
                }
            ],
            [
                'label'=>'接待人员',
                'value' => function($model){
                    return $model->gUser->username;
                }
            ],
            'phone',
            'cate',
            'kefu_qq',
            'addr:ntext',
            'intro:ntext',
            [
                'label' => '是否真实存在',
                'value' => function($model){
                    return $model->is_real ? '是' : '否';
                }
            ],
            'created_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                            ['title' => '编辑', 'class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...",
                                "onclick"=>"return false"] );
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