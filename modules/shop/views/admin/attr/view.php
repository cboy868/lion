<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\core\widgets\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
// use modules\foods\models\Attr;

/* @var $this yii\web\View */
/* @var $model modules\foods\models\Attr */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '属性列表', 'url' => ['index']];

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看

                    <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger  btn-xs',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('添加属性值', ['create-val', 'tid'=>$model->type_id,'aid'=>$model->id], ['class' => 'btn btn-info btn-xs modalAddButton']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php 
            Modal::begin([
                'header' => '添增',
                'id' => 'modalAdd',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-6 attr-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => '分类',
                'value' => $model->type->title
            ],
            'name',
            'body:ntext',
        ],
    ]) ?>

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-xs-6 attr-val-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'val',
            [//todo 这里应该用函数取对应大小的图片
                'label' => '封面',
                'value' => function($model){
                    $img = "<img src='%s' width=36 height=36>";
                    $dir = dirname($model->thumb);
                    $file = basename($model->thumb);

                    $src = $dir .'/36x36@'. $file;
                    // $src = $model->thumb;//Url::toRoute(['/media/thumb', 'src'=>"36x36".$model->thumb]);
                    return sprintf($img, $src);
                },
                'format'=>'raw'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        $uri = Url::toRoute(['update-val', 'id'=>$model->id]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $uri, ['title' => '编辑', 'class'=>'modalEditButton'] );
                    },
                    'delete' => function($url, $model, $key) {
                        $uri = Url::toRoute(['delete-val', 'id'=>$model->id]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $uri, ['title' => '删除', "ria-label"=>"删除", "data-confirm"=>"您确定要删除此项吗？", "data-method"=>"post", "data-pjax"=>"0"] );
                    }
                ],
               'headerOptions' => ['width' => '80']
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>