<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sys\models\AuthRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'real_title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
