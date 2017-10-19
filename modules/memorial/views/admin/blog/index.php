<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

$this->title = '纪念馆文章管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 blog-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
//            'summary:ntext',
//            'thumb',
            'video',
            // 'body:ntext',
            // 'sort',
            // 'recommend',
            // 'is_customer',
            // 'is_top',
            // 'type',
             [
                 'label' => '关联纪念馆',
                 'value' => function($model) {
                    return $model->memorial_id ?
                        \yii\helpers\Html::a($model->memorial->title,
                            ['/memorial/home/hall/index', 'id'=>$model->memorial_id],
                            ['target'=>'_blank']) : '';
                 },
                 'format' => 'raw'
             ],
             'privacyText',
             'view_all',
             'com_all',
            // 'publish_at',
             'user.username',
             'created_at:date',
            // 'updated_at',
            // 'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',

                'template' => '{update} {delete} {view}',

                'headerOptions' => ['width' => '190',"data-type"=>"html"]
            ]

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>