<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '任务列表';
$this->params['breadcrumbs'][] = $this->title;

\app\assets\JqueryuiAsset::register($this);
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
                    <?php if (Yii::$app->user->can('task/default/create')):?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新任务', ['create'], ['class' => 'btn btn-primary btn-sm modalAddButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]) ?>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php 
            Modal::begin([
                'header' => '新增',
                'id' => 'modalAdd',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]

                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]

                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 task-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'info.name',
            'user.username',
            'op.username',
            'title',
            'content:ntext',
            'pre_finish:date',
            'finish',
            'statusText',

            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {view} {finish}',
                'visibleButtons' =>[
                    'update' =>function($model){
                        return Yii::$app->user->can('task/default/update') &&
                            $model->pre_finish >= date('Y-m-d');
                    },
                    'view' => Yii::$app->user->can('task/default/view'),
                    'delete' => Yii::$app->user->can('task/default/delete'),
                    'finish' => Yii::$app->user->can('task/default/finish')
                ],
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        if ($model->status == \app\modules\task\models\Task::STATUS_FINISH) {return '';}
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );
                    },
                    'finish' => function($url, $model, $key) {
                        if ($model->pre_finish < date('Y-m-d')) {
                            return '<span class="overdue">任务过期</span>';
                        }
                        if ($model->status == $model::STATUS_FINISH) {
                            return '';
                        }
                        return Html::a('<span class="fa fa-check"></span>', $url, ['title' => '完成'] );
                    }
                ],
               'headerOptions' => ['width' => '100',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<style>
    .overdue{
        color:red;
        font-weight:700;
    }
    tr.overdue{
        color:red;
    }
</style>

<?php $this->beginBlock('tag') ?>

$(function () {
    $('.overdue').closest('tr').addClass('overdue');
});

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tag'], \yii\web\View::POS_END); ?>