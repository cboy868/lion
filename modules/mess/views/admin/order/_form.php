<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mess\models\MessUserOrderMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mess-user-order-menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mess_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'day_menu_id')->textInput() ?>

    <?= $form->field($model, 'menu_id')->textInput() ?>

    <?= $form->field($model, 'day_time')->textInput() ?>

    <?= $form->field($model, 'real_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'is_pre')->textInput() ?>

    <?= $form->field($model, 'is_over')->textInput() ?>

    <?= $form->field($model, 'is_mobile')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
