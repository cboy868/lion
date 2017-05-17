<?php
use app\core\widgets\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
    // 'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\CheckboxColumn'],
        [
            'label' => '标题',
            'value' => function($model){
                return "<img src='".$model->getThumb('36x36')."'> " . $model->title;
            },
            'format' => 'raw'
        ],
        'author',
        'created_by',
        'category_id',
        [
            'headerOptions' => ["data-breakpoints"=>"all"],
            'attribute' => 'subtitle'
        ],
        [
            'headerOptions' => ["data-breakpoints"=>"all"],
            'attribute' => 'view_all'
        ],
        [
            'headerOptions' => ["data-breakpoints"=>"all"],
            'attribute' => 'created_at',
            'format' => 'datetime'
        ],
        [
            'headerOptions' => ["data-breakpoints"=>"all"],
            'attribute' => 'ip',
        ],
        // 'com_all',
        // 'recommend',
        // 'updated_at',
        // 'status',

        [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'template' => '{update} {delete} {view}',
            'buttons' => [
                'update' => function($url, $model, $key) use ($mod) {
                    $url = Url::toRoute(['update', 'id'=>$model->id, 'mod'=>$mod, 'type'=>'post']);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑'] );
                },
                'view' => function($url, $model, $key) use ($mod) {
                    $url = Url::toRoute(['post-view', 'id'=>$model->id, 'mod'=>$mod]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看'] );
                },
                'delete' => function($url, $model, $key) {
                    $url = Url::toRoute(['delete', 'id'=>$model->id, 'mod'=>\Yii::$app->getRequest()->get('mod')]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除','aria-label'=>"删除", 'data-confirm'=>"您确定要删除此项吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                },

            ],
            'headerOptions' => ['width' => '240',"data-type"=>"html"]
        ]
    ],
]); ?>