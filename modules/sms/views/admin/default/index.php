<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sms\models\SendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '短信管理';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 发送短信', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 send-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mobile',
            'msg:ntext',
            'time',
            'statusText',

            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{view} {delete}',
                'buttons' => [
                    'delete' => function($url, $model, $key) {
                        if ($model->status == $model::STATUS_OK) {
                            return '';
                        }
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除','aria-label'=>"删除", 'data-confirm'=>"您确定要删除此项吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                    },

                ],
                'headerOptions' => ['width' => '80',"data-type"=>"html"]
            ]

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>