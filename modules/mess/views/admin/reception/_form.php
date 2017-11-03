<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mess\models\MessReception */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mess-reception-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mess_id')->textInput() ?>

    <?= $form->field($model, 'reception_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reception_customer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reception_number')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>