<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sys\models\Note */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    div.form-group{
        margin-bottom: 0;
    }
    div.help-block{
        margin:0;
    }
</style>
<div class="note-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'res_name')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'res_id')->hiddenInput()->label(false) ?>

    <?php 

    $form->fieldConfig['template'] = '{label}<div class="col-sm-12">{input}{hint}{error}</div>';
     ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6])->label(false) ?>

	<div class="form-group" style="margin-top:5px">
        <div class="col-sm-offset-9 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
