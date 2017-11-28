<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = ['label' => '食堂', 'url' => ['/mess/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;

\app\assets\JqueryuiAsset::register($this);
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=$this->title?>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 添加新菜单', ['create'],
                        [
                            'class' => 'btn btn-info btn-sm modalAddButton pull-right',
                            'data-loading-text'=>"页面加载中, 请稍后...",
                            'onclick'=>"return false"
                        ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '添加新菜单',
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
            <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <div class="col-xs-2">
                <ul class="nav nav-list">
                    <?php foreach ($cates as $cate=>$name):?>
                        <li class="<?php if(isset($params['category_id']) && $cate == $params['category_id'])echo 'active'?>">
                            <a href="<?=Url::toRoute(['/mess/admin/food/index', 'category_id'=>$cate])?>" class="dropdown-toggle">
                                <i class="menu-icon fa fa-bars"></i>
                                <span class="menu-text"><?=$name?></span>
                            </a>
                        </li>
                    <?php endforeach;?>

                </ul><!-- /.nav-list -->
            </div>

            <div class="col-xs-10 mess-menu-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '',
                'value' => function($model){
                    return $model->getCoverImg('36x36');
                },
                'format'=> 'image'
            ],
            'name',
            'category.name',
            [
                'label' => '原材料',
                'value' => function($model){
                    $foods = $model->foods;
                    $str = '';
                    $units = Yii::$app->getModule('mess')->params['menu_unit'];

                    foreach ($foods as $k => $food) {
                        if (!isset($food->food->food_name)) {
                            continue;
                        }
                        $str .= $food->food->food_name . ':' .$food->num .$units[$food->food->unit_id]. ',';
                    };
                    return $str;
                }
            ],
            'default_price',
            'note',
//             'status',
            // 'created_at',
            // 'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {food}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                            [
                                'title' => '编辑',
                                'class'=>'modalEditButton',
                                "data-loading-text"=>"页面加载中, 请稍后...",
                                "onclick"=>"return false"
                            ]);
                    },
                    'food' => function($url, $model, $key) {
                        return Html::a('食材', $url,
                            [
                                'title' => '食材',
                                'class'=>'modalEditButton',
                                "data-loading-text"=>"页面加载中, 请稍后...",
                                "onclick"=>"return false"
                            ]);
                    }
                ],
                'headerOptions' => ['width' => '240',"data-type"=>"html"]
            ],

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>