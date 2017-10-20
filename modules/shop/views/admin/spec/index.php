<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\search\Attr */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '规格管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
<div class="page-header">
            <h1>
                <small>
                    <a href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm modalAddButton' title="添加规格" data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加规格</a>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <?php 
            Modal::begin([
                'header' => '添加',
                'id' => 'modalAdd',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
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

             <div class="col-xs-2">
                <div class="panel panel-default" style="border-radius:0px;">
                    <ul class="nav nav-list">
                        <?php foreach ($types as $key => $value): ?>
                            <li class="">
                                    <a href="<?=Url::toRoute(['index', 'type_id'=>$value['id']])?>" class="dropdown-toggle">
                                        <i class="menu-icon fa fa-list"></i>
                                        <span class="menu-text"><?=$value['title']?></span>
                                    </a>
                                <b class="arrow"></b>
                            </li>
                        <?php endforeach;?>
                    </ul><!-- /.nav-list -->
                </div>  
            </div>

            <div class="col-xs-10 attr-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            // 'id',
            'typeName',
            'name',
            'multi',
            // 'body:ntext',
            // 'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {view}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );
                    },
                    'view' => function($url, $model, $key) {
                        // $url = Url::toRoute(['/admin/shop/attr-val/create', 'attr_id'=>$model->id]);
                        return Html::a('添加规格值', $url, ['title' => '添加规格值'] );
                    },
                ],
               'headerOptions' => ['width' => '240']
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
