<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

\app\assets\ExtAsset::register($this);
?>

<div class="msg-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'msg')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'msg_time')->textInput(['dt'=>'true']) ?>
	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
