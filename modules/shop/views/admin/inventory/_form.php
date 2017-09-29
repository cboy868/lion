<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="inventory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'goods_id')->textInput() ?>

    <?= $form->field($model, 'sku_id')->textInput() ?>

    <?= $form->field($model, 'record')->textInput() ?>

    <?= $form->field($model, 'actual')->textInput() ?>

    <?= $form->field($model, 'op_id')->textInput() ?>

    <?= $form->field($model, 'diff_num')->textInput() ?>

    <?= $form->field($model, 'diff_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary ']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
