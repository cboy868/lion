<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="mess-supplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mess_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
