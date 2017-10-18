<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

$this->title = '我的审批';
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->params['cur_nav'] = 'approval_index';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新建审批', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
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
//             'status',
//             'create_user',
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