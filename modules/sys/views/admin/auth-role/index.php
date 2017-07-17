<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel sys\models\AuthRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色列表';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 添加角色', ['create'], ['class' => 'btn btn-info btn-sm modalAddButton', 'title'=>"添加角色","data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]) ?>
                </small>
                <?= $this->render('@app/modules/sys/views/admin/layout/_nav.php') ?>
            </h1>
        </div><!-- /.page-header -->


        <?php 
            Modal::begin([
                'header' => '添增',
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

            <div class="col-xs-12 auth-role-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'real_title',
            'description:ntext',
            'rule_name',
            'created_at:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {permission} {user}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );
                    },
                    'permission' => function($url, $model, $key) {
                        return Html::a('分配权限', $url, ['title' => '分配权限', 'class'=>'btn btn-info btn-xs'] );
                    },
                    'user' => function($url, $model, $key) {
                        return Html::a('<span class="fa fa-user"></span>权限用户', $url, ['title' => '权限用户', 'class'=>'btn btn-success btn-xs'] );
                    }
                ],
               'headerOptions' => ['width' => '240']
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>