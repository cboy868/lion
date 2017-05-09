<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\cms\models\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '专题管理';
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

            <div class="col-xs-12 subject-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
//            'id',
            [
                'label' => '封面',
                'value' => function($model){
                    $img = "<img src='%s'>";
                    return sprintf($img, $model->getImg('36x36'));
                },
                'format' => 'raw'
            ],
            'title',
            [
                'label' => '专题分类',
                'value' => function($model) {

                    return \app\modules\cms\models\Subject::cates($model->cate);
                }
            ],
            'user.username',

            [
                'label' => '连接',
                'value' => function($model){
                    $a = "<a href='%s' target='_blank'>%s</a>";
                    return sprintf($a, $model->link, $model->link);
                },
                'format' => 'raw'
            ],
            'path',
            // 'status',
            // 'updated_at',
            // 'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete}',
                'headerOptions' => ['width' => '240',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>