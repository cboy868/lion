<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;


$this->title = '使用人管理';
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

            <div class="col-xs-12 dead-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'emptyCell'=> '',
        'columns' => [
            [
                'label' => '墓位号',
                'value' => function($model){
                    return '<a target="_blank" href="'.Url::toRoute(["/grave/admin/tomb/view", 'id'=>$model->tomb_id]).'">'.$model->tomb->tomb_no.'</a>';
                },
                'format'=>'raw'
            ],
            'dead_name',
            [
                'label' => '账号',
                'value' => function($model){
                    return $model->user->username;
                }
            ],
            [
                'label' => '纪念馆名',
                'value' => function($model){
                    if (!isset($model->memorial)) {return '';}
                    return Html::a($model->memorial->title, ['/memorial/home/default/view', 'id'=>$model->memorial_id], ['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            // 'second_name',
            // 'dead_title',
            // 'serial',
            // 'gender',
            // 'birth_place',
            'birth',
            'fete',
            // 'is_alive',
            // 'is_adult',
            // 'age',
            // 'follow_id',
            // 'desc:ntext',
            // 'is_ins',
            // 'bone_type',
            // 'bone_box',
            [
                'label' => '预葬日期',
                'value' => function($model){
                    return $model->pre_bury ? date('Y-m-d', strtotime($model->pre_bury)) : '';
                }
            ],
            'bury',
            'created_at:datetime',
            // 'updated_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('grave/dead/update'),
                    'view' =>Yii::$app->user->can('grave/dead/view'),
                    'delete' =>Yii::$app->user->can('grave/dead/delete'),
                ],
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>