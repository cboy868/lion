<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\CarRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'tomb_id')->textInput() ?>

    <?= $form->field($model, 'car_id')->textInput() ?>

    <?= $form->field($model, 'driver_id')->textInput() ?>

    <?= $form->field($model, 'use_date')->textInput() ?>

    <?= $form->field($model, 'use_time')->textInput() ?>

    <?= $form->field($model, 'contact_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_num')->textInput() ?>

    <?= $form->field($model, 'addr_id')->textInput() ?>

    <?= $form->field($model, 'addr')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_cremation')->textInput() ?>

    <?= $form->field($model, 'car_type')->textInput() ?>



	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
