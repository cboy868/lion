<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\search\InsCfgCase */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '配置项管理';
$this->params['breadcrumbs'][] = ['label' => '配置首页', 'url' => ['/grave/admin/ins-cfg/index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= $this->title ?> 
                <small class="pull-right">

                    <?= Html::a('配置列表', ['/grave/admin/ins-cfg/index', 'id' => Yii::$app->request->get('cfg_id')], ['class' => 'btn btn-info btn-sm']) ?>
                    <?= Html::a('<i class="fa fa-plus"></i> 添加配置', ['create', 'cfg_id'=>Yii::$app->request->get('cfg_id')], ['class' => 'btn btn-info btn-sm modalAddButton']) ?>
                </small>
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
                'header' => '编辑',
                'id' => 'modalEdit',
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

            <div class="col-xs-12 ins-cfg-case-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'num',
            'width',
            'height',
            [
                'label' => '样图',
                'value' => function($model) {
                    $img = "<img src='$model->img' style='max-width:100px;max-height:100px'>";
                    return $img;
                },
                'format' =>'raw'
            ],
            // 'status',
            // 'sort',
            // 'add_time',
            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {edit}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton'] );
                    },
                    'edit' => function($url, $model, $key) {
                        $url = Url::toRoute(['/grave/admin/ins-cfg-value/index', 'case_id'=>$model->id]);
                        return Html::a('图片配置', $url, ['title' => '图片配置', 'class'=>''] );
                    },

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