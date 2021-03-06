<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

$this->params['current_menu'] = 'grave/customer/index';

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '客户列表', 'url' => ['index']];
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
            <div class="col-xs-10 customer-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tomb.tomb_no',
            'user.username',
            'name',
            'phone',
            'mobile',
            'email:email',
            'second_ct',
            'second_mobile',
            'units',
            'relation',
            'is_vip',
            'vip_desc:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>