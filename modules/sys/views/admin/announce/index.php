<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\sys\models\Announce;
\app\assets\JqueryuiAsset::register($this);

$this->title = '公告';
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
                    <?php if (Yii::$app->user->can('sys/announce/create')):?>
                        <a id="modalButton" href="<?=Url::to(['create', 'type'=>Announce::TYPE_SYS])?>"
                           class='btn btn-info modalAddButton'
                           title="发布系统公告"
                           data-loading-text="页面加载中, 请稍后..." onclick="return false">发布系统公告</a>

                        <a id="modalButton" href="<?=Url::to(['create', 'type'=>Announce::TYPE_WEB])?>"
                           class='btn btn-primary modalAddButton'
                           title="发布网站公告"
                           data-loading-text="页面加载中, 请稍后..." onclick="return false">发布网站公告</a>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->


        <?php
        Modal::begin([
            'header' => '添加公告',
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
            <div class="col-md-12">
                <?=\app\core\widgets\Alert::widget();?>
            </div>

            <div class="col-xs-12 announce-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        'columns' => [
            'title',
            'content:ntext',
            'author',
             'start',
             'end',
             'type',
             'view_num',
             'created_at:datetime',
            // 'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>