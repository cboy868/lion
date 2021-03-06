<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\BurySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '安葬记录';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=$this->title?>
                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['pre'])?>">
                        <i class="fa fa-th fa-2x"></i>  预葬记录</a>
                </div>
            </h1>
        </div><!-- /.page-header -->
        <div class="row">


            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 bury-index">

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
            'pre_bury_date',
            'bury_date',
            'bury_time',
            'buser.username',
            // 'bury_order',
            'note:ntext',
            'created_at:datetime',
            // 'updated_at',
            // 'status',
            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' =>[
                    'delete' =>Yii::$app->user->can('grave/bury/delete'),
                ],
                'template' => '{delete}',
            ]

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>