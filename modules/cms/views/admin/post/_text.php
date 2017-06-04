<?php
use app\core\widgets\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\cms\models\Post;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
    // 'filterModel' => $searchModel,
    'id' => 'grid',
    'showFooter' => true,  //设置显示最下面的footer
    'columns' => [
        [
            'class'=>yii\grid\CheckboxColumn::className(),
            'name'=>'id',  //设置每行数据的复选框属性
            'headerOptions' => ['width'=>'30'],
            'footer' => '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
            'footerOptions' => ['colspan' => 5, 'class'=>'deltd'],  //设置删除按钮垮列显示；
        ],
        //['class' => 'yii\grid\CheckboxColumn'],
        [
            'label' => '标题',
            'value' => function($model){
                return "<img src='".$model->getCover('36x36')."'> " . $model->title;
            },
            'format' => 'raw'
        ],
        'author',
        'createdBy.username',
        'category.name',
        [
            'headerOptions' => ["data-breakpoints"=>"all"],
            'attribute' => 'subtitle'
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
        'view_all',
        'com_all',
        // 'recommend',
        // 'updated_at',
        // 'status',

        [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'template' => '{update} {delete} {view} {update-lg}',
            'buttons' => [
                'update' => function($url, $model, $key) use ($mid) {
                    $url = Url::toRoute(['update', 'id'=>$model->id, 'mid'=>$mid, 'type'=>Post::types($model->type)]);
                    $class = '';
                    if ($model->type == Post::TYPE_IMAGE) {
                        $class="modalEditButton";
                    }
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>$class] );
                },
                'view' => function($url, $model, $key) use ($mid) {
                    $url = Url::toRoute(['view', 'id'=>$model->id, 'mid'=>$mid]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看'] );
                },
                'delete' => function($url, $model, $key) use ($mid) {
                    $url = Url::toRoute(['delete', 'id'=>$model->id, 'mid'=>$mid]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除','aria-label'=>"删除", 'data-confirm'=>"您确定要删除此项吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                },
                'update-lg' => function($url, $model, $key) use ($mid) {
                    $url = Url::toRoute(['update-lg', 'id'=>$model->id, 'mid'=>$mid, 'type'=>Post::types($model->type)]);
                    return Html::a('多语言编辑', $url, ['title' => '多语言'] );
                },

            ],
            'headerOptions' => ['width' => '240',"data-type"=>"html"]
        ]
    ],
]); ?>



<?php $this->beginBlock('img') ?>
$(function(){
$('.btn-delete').click(function(){

    if (!confirm("您确定要删除这些文章吗?,删除后不可恢复")){return false;}

    var ids = $('#grid').yiiGridView('getSelectedRows');
    var url = "<?=Url::toRoute(['batch-del'])?>";
    var mid = "<?=$mid?>";

    $.post(url, {mid:mid,ids:ids},function(xhr){
        if (xhr.status){
            location.reload();
        } else {
            alert(xhr.info);
        }
    },'json');

});

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>

