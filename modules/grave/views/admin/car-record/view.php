<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\CarRecord */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Car Records', 'url' => ['index']];
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
            <div class="col-xs-10 car-record-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'tomb_id',
            'grave_id',
            'dead_id',
            'dead_name',
            'car_id',
            'driver_id',
            'use_date',
            'use_time',
            'price',
            'contact_user',
            'contact_mobile',
            'user_num',
            'addr_id',
            'addr:ntext',
            'status',
            'note:ntext',
            'order_id',
            'order_rel_id',
            'is_cremation',
            'car_type',
            'updated_at',
            'created_at',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>