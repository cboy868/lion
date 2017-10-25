<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="mess-food-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea() ?>

	<div class="form-group">
        <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
