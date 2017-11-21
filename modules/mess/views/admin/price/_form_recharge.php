<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="mess-user-recharge-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true])
        ->label('为'.$user->username.'账户充值,金额:')
    ->hint('当前余额:'.$price->price);
    ?>

	<div class="form-group">
        <div class="col-sm-3 pull-right">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
