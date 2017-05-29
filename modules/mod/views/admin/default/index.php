<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
$this->title = '模块管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    td img{
        width:45px;
        height:45px;
    }
</style>
<div class="page-content">
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <a href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm modalAddButton' title="添加模块"
                       data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加模块</a>
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
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 module-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        'columns' => [
            'id',
            'logo:image',
            'title',
            'name',
            'intro:ntext',
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update}  {delete}  {category} {info} {models}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="fa fa-edit fa-lg"></span>',
                            $url,
                            [
                                'title' => '编辑',
                                'class'=>'modalEditButton',
                                "data-loading-text"=>"页面加载中, 请稍后...",
                                "onclick"=>"return false"
                            ]);
                    },
                    'category' => function($url, $model, $key) {
                        $url = Url::toRoute(['/cms/admin/category/index', 'mid'=>$model->id]);
                        return Html::a('分类管理',
                            $url,
                            [
                                'title' => '分类管理',
                                'target' => '_blank',
                                'class'=>'btn btn-success btn-xs'
                            ]);
                    },
                    'info' => function($url, $model, $key) {
                        $url = Url::toRoute(['/cms/admin/post/index', 'mid'=>$model->id]);
                        return Html::a('内容管理',
                            $url,
                            [
                                'title' => '内容管理',
                                'target' => '_blank',
                                'class'=>'btn btn-success btn-xs'
                            ]);
                    },
                    'models' => function($url, $model, $key) {
                        $url = Url::toRoute(['/mod/admin/models/index', 'mid'=>$model->id]);
                        return Html::a('<span class="fa fa-table"></span>模型管理',
                            $url, ['title' => '模型管理', 'class'=>'btn btn-success btn-xs'] );
                    }
                ],
                'headerOptions' => ['width' => '280',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>