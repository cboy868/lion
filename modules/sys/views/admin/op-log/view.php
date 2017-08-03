<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '系统操作日志', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看
                    <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
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
            <div class="col-xs-10 op-log-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => '操作人',
                'value' => $model->user_id ? $model->user->username : ''
            ],
            'table_name',
            'ac',
            'route',
            'description:ntext',
            'created_at:datetime',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>