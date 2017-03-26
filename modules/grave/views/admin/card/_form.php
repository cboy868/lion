<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Card */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tomb_id')->hiddenInput()->label(false) ?>

     <?php
        $form->fieldConfig['template'] = '{label}<div class="col-sm-5">{input}{hint}{error}</div>';
        $form->fieldConfig['labelOptions']['class'] = 'control-label col-sm-2';
        $form->fieldConfig['options']['class'] = 'form-g';
    ?>

    <?= $form->field($model, 'start')->textInput(['placeholder'=>'起始','dt'=>'true','dt-year' => 'true','dt-month' =>'true'])->label(false) ?>

    <?= $form->field($model, 'end')->textInput(['placeholder'=>'截止','dt'=>'true','dt-year' => 'true','dt-month' =>'true'])->label(false) ?>

        <div class="col-sm-2">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    
    <?php ActiveForm::end(); ?>

</div>
