<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\mod\models\FieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = '字段管理';
// $this->params['breadcrumbs'][] = $this->title;





// $this->title = ' ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '模块管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '字段管理';

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 添加字段', ['create-field', 'id'=>Yii::$app->getRequest()->get('id')], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 field-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        'columns' => [
            'table',
            'name',
            'title',
            'pop_note',
            'html',
            'option:ntext',
            'default:ntext',
            'is_show',
            'order',
            // 'created_at',


            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {view}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        $url = Url::toRoute(['/admin/cms/post/update', 'id'=>$model->id, 'mod'=>\Yii::$app->getRequest()->get('mod')]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑'] );
                    },
                    'view' => function($url, $model, $key) {
                        $url = Url::toRoute(['/admin/cms/post/view', 'id'=>$model->id, 'mod'=>\Yii::$app->getRequest()->get('mod')]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看'] );
                    },
                    'delete' => function($url, $model, $key) {
                        $url = Url::toRoute(['/admin/cms/post/delete', 'id'=>$model->id, 'mod'=>\Yii::$app->getRequest()->get('mod')]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除','aria-label'=>"删除", 'data-confirm'=>"您确定要删除此项吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                    },

                ],
               'headerOptions' => ['width' => '240',"data-type"=>"html"]
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>