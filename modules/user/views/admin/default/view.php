<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
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
            <div class="col-xs-10 user-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

    <?php 

    $field = [];

    foreach ($attach as $k => $v) {
        $field[] = $v['name'];
    }

        $attributes = [
            'real_name',
            [
                'label' => '性别',
                'value' => $addition->gender == 1 ? '女' : '男',
            ],
            'qq',
            'birth',
            'height',
            'weight',
            'address',
            'hobby',
            'native_place',
            'intro',
        ] + $field;

        $attributes = array_merge($attributes, $field);


     ?>

    <?= DetailView::widget([
        'model' => $addition,
        'attributes' => $attributes
    ]) ?>





                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>