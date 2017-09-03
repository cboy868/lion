<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

$this->params['current_menu'] = 'order/refund/index';
?>

<div class="refund-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'progress')->textInput() ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
