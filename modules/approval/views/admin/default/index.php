<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

$this->title = '审批管理';
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

            <div class="col-xs-12 approval-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
//            'pid',
            'process.title',
            'title',
            'total',
             'yet_money',
             'pay',
             'intro:ntext',
             'progress',
             'nowstep',
            [
                'label' => '审批次数',
                'value' => function($model){
                    return '第' . $model->time .'次';
                }
            ],
//             'status',
             'user.username',
//             'eng_id',
             'created_at:datetime',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>