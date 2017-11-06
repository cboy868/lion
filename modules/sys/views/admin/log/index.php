<?php

use app\core\helpers\Html;
use app\core\widgets\GridView;
use app\core\libs\Ip\IpLocation;

$this->title = '系统调试日志';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  Html::a($this->title, ['index']) ?>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 log-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <style>
                    .table-striped>tbody>tr:nth-child(odd)>td, .table-striped>tbody>tr:nth-child(odd)>th{
                        -ms-word-break: break-all;
                        word-break: break-all;
                    }
                </style>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
                'id',
            'level',
            'category',
            'log_time:datetime',
            'prefix',
            [
                'label' => 'prefix',
                'value' => function($model){
                    $arr = preg_split("/(\[|\])/",$model->prefix);

                    $ip = new IpLocation();
                    $ipresult =  $arr[1] ? $ip->getlocation($arr[1]) : '';

                    if (!$ipresult) {
                        return $model->prefix;
                    } else {
                        return $model->prefix . $ipresult['country']. $ipresult['area'];
                    }
                }
            ],
            'message:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{view}',
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>