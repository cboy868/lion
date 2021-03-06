<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;


$this->title = '收藏';
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

            <div class="col-xs-12 favor-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'user.username',
            'res_name',
            'res_id',
            [
                'label' => '资源名',
                'value' => function($data){
                    return Html::a($data->title, Yii::$app->request->hostInfo . $data->res_url, ['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            // 'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' =>[
                    'delete' =>Yii::$app->user->can('cms/favor/delete'),
                ],
                'header'=>'操作',
                'template' => '{delete}',
                'headerOptions' => ['width' => '140',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>