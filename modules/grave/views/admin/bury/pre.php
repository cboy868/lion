<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '预葬记录';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1 >
                <?=$this->title?>
                <small style="">
                </small>
                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['index'])?>">
                        <i class="fa fa-th fa-2x"></i>  安葬记录</a>
                </div>
            </h1>
        </div><!-- /.page-header -->
        <?php
        Modal::begin([
            'header' => '新增',
            'id' => 'modalAdd',
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '确认安葬',
            'id' => 'modalEdit',
            // 'size' => 'modal'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
            [
                'header' => '操作',
                'headerOptions' => ['width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {confirm}',
                'buttons' => [
                    'confirm' => function($url, $model, $key) {
                        return Html::a('确认安葬', $url, [
                                'title' => '确认安葬',
                                'data-confirm' => '请确定此记录已完成',
                                'data-method'=>"post",
                                'data-pjax' => '0'
                        ] );
                    }
                ],
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
