<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\modules\task\models\Info;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Info */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '任务分类信息', 'url' => ['info']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看
                    <?= Html::a('Edit', ['update-info', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
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
            <div class="col-xs-10 info-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'intro:ntext',
            'msg:ntext',
            [   
                'label' => '提醒方式',
                'value' => $model->getMsgType()
            ],
            [
                'label' => '提醒时间',
                'value' => $model->getTimes()
            ],
            [
                'label' => '触发方式',
                'value' => Info::trig($model->trigger),
            ],
            'statusText',
            'created_at:datetime',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>