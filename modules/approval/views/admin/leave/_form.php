<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\ApprovalLeave */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-leave-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'approval_id')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
