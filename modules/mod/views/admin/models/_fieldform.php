<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mod\models\Field */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="field-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('字段名,英文字母组成') ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('字段标题') ?>

    <?= $form->field($model, 'pop_note')->textInput(['maxlength' => true])->hint('此字段添写内容时的提示信息') ?>

    <?= $form->field($model, 'html')->dropDownList(['input'=>'input',  'textarea'=>'textarea', 'fulltext'=>'fulltext']) ?><!-- ,'radio'=>'radio','select'=>'select','checkbox'=>'checkbox' -->

    <?= $form->field($model, 'option')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'default')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_show')->radioList([0=>'否', 1=>'是']) ?>

    <?= $form->field($model, 'table')
                        ->hiddenInput(['maxlength' => true, 'value'=> isset($mInfo->module) ? $mInfo->module : $model->table])
                        ->label(false) ?>

    <?= $form->field($model, 'model_id')->hiddenInput()->label(false) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
