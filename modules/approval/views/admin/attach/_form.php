<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\ApprovalAttach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-attach-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'approve_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'ext')->textInput(['maxlength' => true]) ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
