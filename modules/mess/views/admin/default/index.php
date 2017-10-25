<?php

use app\core\helpers\Html;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = '食堂基础设置';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  Html::a($this->title, ['index']) ?>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '添加',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '编辑',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-md-6">
                <h1>
                    <small>
                        <a href="<?=Url::to(['create'])?>"
                           class='btn btn-info btn-sm modalAddButton' title="添加食堂"
                           data-loading-text="页面加载中, 请稍后..." onclick="return false">
                            <i class="fa fa-plus"></i>添加食堂
                        </a>
                    </small>
                </h1>
                <div class="row">
                    <div class="col-xs-12 mess-index">

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                            // 'filterModel' => $searchModel,
                            'columns' => [
                                'name',
                                'note',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header'=>'操作',
                                    'template' => '{update} {delete}',
                                    'buttons' => [
                                        'update' => function($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                                [
                                                    'title' => '编辑',
                                                    'class'=>'modalEditButton',
                                                    "data-loading-text"=>"页面加载中, 请稍后...",
                                                    "onclick"=>"return false"]
                                            );
                                        },
                                        'delete' =>function($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>删除',$url,[
                                                'data-confirm'=>"您确定要删除此项吗？",
                                                "data-method"=>"post"
                                            ]);
                                        }
                                    ],
                                    'headerOptions' => ['width' => '240',"data-type"=>"html"]
                                ]
                            ],
                        ]); ?>
                        <div class="hr hr-18 dotted hr-double"></div>
                    </div><!-- /.col -->
                </div>
            </div>
            <div class="col-md-6">
                <h1>
                    <small>
                        <a href="<?=Url::to(['create-supplier'])?>"
                           class='btn btn-info btn-sm modalAddButton' title="添加供应商"
                           data-loading-text="页面加载中, 请稍后..." onclick="return false">
                            <i class="fa fa-plus"></i>添加供应商
                        </a>
                    </small>
                </h1>
                <div class="row">

                    <div class="col-xs-12 mess-supplier-index">

                        <?= GridView::widget([
                            'dataProvider' => $supProvider,
                            'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                            // 'filterModel' => $searchModel,
                            'columns' => [
                                'mess.name',
                                'name',
                                'contact',
                                'mobile',
                                'note',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header'=>'操作',
                                    'template' => '{update-supplier} {delete-supplier}',
                                    'buttons' => [
                                        'update-supplier' => function($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                                [
                                                    'title' => '编辑',
                                                    'class'=>'modalEditButton',
                                                    "data-loading-text"=>"页面加载中, 请稍后...",
                                                    "onclick"=>"return false"]
                                            );
                                        },
                                        'delete-supplier' =>function($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>删除',$url,[
                                                'data-confirm'=>"您确定要删除此项吗？",
                                                "data-method"=>"post"
                                            ]);
                                        }

                                    ],
                                    'headerOptions' => ['width' => '240',"data-type"=>"html"]
                                ]
                            ],
                        ]); ?>
                        <div class="hr hr-18 dotted hr-double"></div>
                    </div><!-- /.col -->
                </div>
            </div>

            <div class="col-md-6">
                <h1>
                    <small>
                        <a href="<?=Url::to(['create-food'])?>"
                           class='btn btn-info btn-sm modalAddButton' title="添加原材料分类"
                           data-loading-text="页面加载中, 请稍后..." onclick="return false">
                            <i class="fa fa-plus"></i>添加原材料分类
                        </a>
                    </small>
                </h1>
                <div class="row">

                    <div class="col-xs-12 mess-supplier-index">

                        <?= GridView::widget([
                            'dataProvider' => $foodCateProvider,
                            'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                            // 'filterModel' => $searchModel,
                            'columns' => [
                                'name',
                                'note',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header'=>'操作',
                                    'template' => '{update-food} {delete-food}',
                                    'buttons' => [
                                        'update-food' => function($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                                [
                                                    'title' => '编辑',
                                                    'class'=>'modalEditButton',
                                                    "data-loading-text"=>"页面加载中, 请稍后...",
                                                    "onclick"=>"return false"]
                                            );
                                        },
                                        'delete-food' =>function($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>删除',$url,[
                                                'data-confirm'=>"您确定要删除此项吗？",
                                                "data-method"=>"post"
                                            ]);
                                        }
                                    ],
                                    'headerOptions' => ['width' => '240',"data-type"=>"html"]
                                ]
                            ],
                        ]); ?>
                        <div class="hr hr-18 dotted hr-double"></div>
                    </div><!-- /.col -->
                </div>
            </div>

            <div class="col-md-6">
                <h1>
                    <small>
                        <a href="<?=Url::to(['create-menu'])?>"
                           class='btn btn-info btn-sm modalAddButton' title="添加成品分类"
                           data-loading-text="页面加载中, 请稍后..." onclick="return false">
                            <i class="fa fa-plus"></i>添加成品分类
                        </a>
                    </small>
                </h1>
                <div class="row">

                    <div class="col-xs-12 mess-supplier-index">

                        <?= GridView::widget([
                            'dataProvider' => $menuCateProvider,
                            'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                            'columns' => [
                                'name',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header'=>'操作',
                                    'template' => '{update-menu} {delete-menu}',
                                    'buttons' => [
                                        'update-menu' => function($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                                [
                                                    'title' => '编辑',
                                                    'class'=>'modalEditButton',
                                                    "data-loading-text"=>"页面加载中, 请稍后...",
                                                    "onclick"=>"return false"]
                                            );
                                        },
                                        'delete-menu' =>function($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>删除',$url,[
                                                'data-confirm'=>"您确定要删除此项吗？",
                                                "data-method"=>"post"
                                            ]);
                                        }
                                    ],
                                    'headerOptions' => ['width' => '240',"data-type"=>"html"]
                                ]
                            ],
                        ]); ?>
                        <div class="hr hr-18 dotted hr-double"></div>
                    </div><!-- /.col -->
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>