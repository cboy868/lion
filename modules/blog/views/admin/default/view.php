<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '博客管理', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger  btn-xs',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-10 blog-view">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'title',
                        [
                            'label' => '纪念馆',
                            'value' =>function($model){
                                return Html::a($model->memorial->title,
                                    ['/memorial/home/hall/index', 'id'=>$model->memorial_id],
                                    ['target'=>'_blank']
                                );
                            },
                            'format' => 'raw'
                        ],
                        'privacyText',
                        'view_all',
                        'com_all',
                        'user.username',
                        'ip',
                        'created_at:datetime',
                        'summary:ntext',
                        'body:raw',
                    ],
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>