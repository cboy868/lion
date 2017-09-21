<?php

use app\core\helpers\Html;
use app\core\widgets\GridView;
use yii\helpers\Url;



$this->title = '免费葬期次管理';
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

            <div class="col-xs-12 free-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [

            'id',
            'title',
            'type',
            'bury_date:datetime',
            'max_num',
             'note:ntext',
             'op_user',
             'op_mobile',
            // 'status',
             'created_at:datetime',
            // 'op_id',
             'stage',
            'statusText',
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('grave/free/update'),
                    'view' =>Yii::$app->user->can('grave/free/view'),
                    'delete' =>Yii::$app->user->can('grave/free/delete'),
                    'finish' =>Yii::$app->user->can('grave/free/finish'),
                    'dead' =>Yii::$app->user->can('grave/free-dead/index'),
                ],
                'template' => '{update} {delete} {view} {dead} {finish}',
                'buttons' => [
                    'dead' => function($url, $model, $key) {
                        $url = Url::toRoute(['/grave/admin/free-dead/index', 'free_id'=>$model->id]);
                        return Html::a('逝者管理', $url, ['title' => '逝者管理', 'target'=>'_blank']);
                    },
                    'finish' => function($url, $model, $key) {
                        if ($model->status == \app\modules\grave\models\Free::STATUS_NORMAL) {
                            return Html::a('活动完成', $url, [
                                    'title' => '活动完成',
                                    'class'=>'btn btn-info btn-xs',
                                    'data-confirm'=>"请再次确认本次活动已完成",
                                    'data-method'=>"post"
                            ]);
                        }
                    }

                ],
            ],

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>