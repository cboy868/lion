<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="mess-menu-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
