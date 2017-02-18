<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\search\CarRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-record-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'tomb_id') ?>

    <?= $form->field($model, 'grave_id') ?>

    <?= $form->field($model, 'dead_id') ?>

    <?php // echo $form->field($model, 'dead_name') ?>

    <?php // echo $form->field($model, 'car_id') ?>

    <?php // echo $form->field($model, 'driver_id') ?>

    <?php // echo $form->field($model, 'use_date') ?>

    <?php // echo $form->field($model, 'use_time') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'contact_user') ?>

    <?php // echo $form->field($model, 'contact_mobile') ?>

    <?php // echo $form->field($model, 'user_num') ?>

    <?php // echo $form->field($model, 'addr_id') ?>

    <?php // echo $form->field($model, 'addr') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'order_rel_id') ?>

    <?php // echo $form->field($model, 'is_cremation') ?>

    <?php // echo $form->field($model, 'car_type') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
