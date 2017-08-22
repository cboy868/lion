<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="remote-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'video')->textInput(['maxlength' => true])->hint('推荐mp4格式') ?>

    <div class="form-group">
        <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-sm pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
