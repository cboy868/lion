<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sms\models\SendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '短信管理';
$this->params['breadcrumbs'][] = $this->title;

\app\assets\ExtAsset::register($this);

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=Html::encode($this->title) ?>
                <small>
                </small>
            </h1>
        </div><!-- /.page-header -->


        <div class="row">
            <div class="col-xs-12 send-create">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="border: 2px solid #ccc;">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    发送新短信
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">

                                <div class="send-form">

                                    <?php $form = ActiveForm::begin(); ?>


                                    <?php
                                    $form->fieldConfig['labelOptions']['class'] = 'control-label col-sm-1';
                                    ?>

                                    <?= $form->field($model, 'type')->radioList(['staff'=>'全体员工', 'customer'=>'所有客户', 'other'=>'自定义']) ?>

                                    <?= $form->field($model, 'mobile')->textArea(['rows' => 6])->hint('多个电话请用逗号(,)分隔') ?>

                                    <?= $form->field($model, 'msg')->textarea(['rows' => 6]) ?>


                                    <?= $form->field($model, 'time')->textInput(['dt'=>'true', 'style'=>'width:50%'])->hint('不填写则马上发送') ?>

                                    <div class="form-group">
                                        <div class=" col-sm-3">
                                            <?=  Html::submitButton('发 送', ['class' => 'btn btn-primary btn-block']) ?>
                                        </div>
                                    </div>

                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 send-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mobile',
            'msg:ntext',
            'time',
            'statusText',

            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{delete}',
                'visibleButtons' =>[
                    'delete' =>Yii::$app->user->can('sms/default/delete'),
                ],
                'buttons' => [
                    'delete' => function($url, $model, $key) {
                        if ($model->status == $model::STATUS_OK) {
                            return '';
                        }
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除','aria-label'=>"删除", 'data-confirm'=>"您确定要删除此项吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                    },

                ],
                'headerOptions' => ['width' => '80',"data-type"=>"html"]
            ]

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>