<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\ApprovalStep */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-step-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'approval_id')->textInput() ?>

    <?= $form->field($model, 'step_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'step')->textInput() ?>

    <?= $form->field($model, 'approval_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'progress')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
