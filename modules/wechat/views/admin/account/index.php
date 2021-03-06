<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;


$this->title = '微信账号列表';
$this->params['breadcrumbs'][] = $this->title;

?>

<link rel="stylesheet" href="/css/wechat.css">

<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">

        <?= $this->render('../default/left');?>
        <div class="right-content">

            <div class="page-header">
                <h1>
                    <!--
                <?=  Html::a($this->title, ['index']) ?>
            -->
                    <small>
                        <?php if (Yii::$app->user->can('wechat/account/create')):?>
                        <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                        <?php endif;?>
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>

                <div class="col-xs-12 wechat-index">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
//            'token',
//            'access_token',
//            'encodingaeskey',
//            'level',
                            'name',
                            'original',
                            'appid',
                            'appsecret',
                            // 'status',
                            // 'created_at',


                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header'=>'操作',
                                'template' => '{update} {delete} {view} {switch}',
                                'visibleButtons' =>[
                                    'update' =>Yii::$app->user->can('wechat/account/update'),
                                    'view' =>Yii::$app->user->can('wechat/account/view'),
                                    'delete' =>Yii::$app->user->can('wechat/account/delete'),
                                    'switch' =>Yii::$app->user->can('wechat/account/switch'),
                                ],
                                'buttons' => [
                                    'switch' => function($url, $model, $key) {
                                        return Html::a('进入公众号', $url, ['title' => '进入公众号'] );
                                    }
                                ],
                                'headerOptions' => ['width' => '240',"data-type"=>"html"]
                            ]
                        ],
                    ]); ?>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
    </div>
</div>





















































<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

    </div><!-- /.page-content-area -->
</div>