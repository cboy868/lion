<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

$this->params['current_menu'] = 'ashes/default/index';

?>

<div class="box-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'box_no')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
