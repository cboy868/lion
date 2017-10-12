<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\memorial\models\MemorialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '纪念馆管理';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 memorial-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'headerOptions' => ['width' => '80'],
                'label' => '封面',
                'value' => function($model){
                    return $model->getCover('50x50');
                },
                'format'=>'image'
            ],
            [
                'label' => '纪念馆名',
                'value' => function($model){
                    return Html::a($model->title, Url::toRoute(['/memorial/home/hall/index', 'id'=>$model->id]),['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            'title',
            // 'intro:ntext',
            'privacyText',
             'view_all',
//             'com_all',
//            'tpl',
            'statusText',
            // 'status',
            // 'updated_at',
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',

                'template' => '{update} {delete} {view} {apply} ',
                'buttons' => [
                    'apply' => function($url, $model, $key){
                        if ($model->status == \app\modules\memorial\models\Memorial::STATUS_APPLY) {
                            return Html::a('<font color="green"> 通过</font>', $url, ['title' => '通过审核', 'class'=>'top'] );
                        }
                    },
                    'view' => function($url, $model, $key){
                        return Html::a('查看', Url::toRoute(['/memorial/home/hall/index', 'id'=>$model->id]), ['target'=>'_blank']);
                    }
                ],
                'headerOptions' => ['width' => '190',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>