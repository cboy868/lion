<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

$this->params['current_menu'] = 'cms/post/index';

$this->title = $module->title . '模型管理';
$this->params['breadcrumbs'][] = ['label' => '模块管理', 'url' => ['/mod/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title)?>
                <small>

                </small>
            </h1>
        </div><!-- /.page-header -->

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
            'module',
            'name',
            // 'dir',
            // 'link',
            'order',
            'showLabel',
//             'logo',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{field}',
                'buttons' => [
                    'field' => function($url, $model, $key) {
                        return Html::a('<span class="fa fa-table"></span>字段管理', $url, ['title' => '权限用户', 'class'=>'btn btn-success btn-xs'] );
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