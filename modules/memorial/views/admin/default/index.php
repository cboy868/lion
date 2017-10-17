<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;

Yii::$app->params['cur_nav'] = 'memorial_index';

$this->title = '纪念馆管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>纪念馆管理

                <small>
                    <div class="pull-right nc">
                        <a class="btn btn-danger btn-sm" href="<?=Url::toRoute(['/memorial/member/default/create'])?>">
                            <i class="fa fa-plus"></i>  创建纪念馆</a>
                    </div>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <style>
                .dead{
                    float:left;
                    width:100px;
                }
                .dead a,table a{
                    color:#333;
                }
                .mem img{
                    float:left;
                }
                .mem ul{
                    float: left;
                    margin-left:10px;
                }
            </style>
            <div class="col-xs-12 memorial-index">
                <div class="table-responsive">

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
                                        return Html::a('详细资料', Url::toRoute(['/memorial/admin/default/update', 'id'=>$model->id]), ['target'=>'_blank']);
                                    }
                                ],
                                'headerOptions' => ['width' => '190',"data-type"=>"html"]
                            ]
                        ],
                    ]); ?>

                </div>
            </div>
        </div>

    </div><!-- /.page-content-area -->
</div>
