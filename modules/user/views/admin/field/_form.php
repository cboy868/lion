<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['current_menu'] = 'user/field/index';
?>

<div class="user-field-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('字段名,英文字母组成') ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('字段标题') ?>

    <?= $form->field($model, 'pop_note')->textInput(['maxlength' => true])->hint('此字段添写内容时的提示信息') ?>

    <?= $form->field($model, 'html')->dropDownList(['input'=>'input',  'textarea'=>'textarea', 'fulltext'=>'fulltext']) ?><!-- ,'radio'=>'radio','select'=>'select','checkbox'=>'checkbox' -->

    <?php //echo $form->field($model, 'option')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'default')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'is_show')->radioList([0=>'否', 1=>'是']) ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
