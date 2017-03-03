<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\BurySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '预葬记录';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1 style="text-align:right">
                <small style="">
                    <?=Html::a('安葬记录', ['index'], ['class'=>'btn btn-info']); ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 bury-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'tomb.tomb_no',
            'user.username',
            'dead_name',
            // 'dead_num',
            // 'bury_type',
            [
                'label' => '预葬日期',
                'value' => function($model){
                    return substr($model->pre_bury_date, 0, 10);
                }
            ],
            // 'bury_order',
            'note:ntext',
            'created_at:datetime',
            // 'updated_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>