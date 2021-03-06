<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
\app\assets\ExtAsset::register($this);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-5">
        <?= $form->field($addition, 'real_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($addition, 'birth')->textInput(['maxlength' => true,'dt'=>'true','dt-year'=>'true', 'dt-month'=>'true']) ?>
        <?= $form->field($addition, 'gender')->radioList(['1'=> '男', '2'=>'女']) ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($addition, 'height')->textInput(['maxlength' => true, 'placeholder'=>'单位:cm']) ?>
        <?= $form->field($addition, 'weight')->textInput(['maxlength' => true, 'placeholder'=>'单位:kg']) ?>
        <?= $form->field($addition, 'qq')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-2">
        <img src="<?=$model->getAvatar('150x150')?>" class="img-responsive img-thumbnail" alt="Responsive image">
    </div>

    <div class="col-md-12">
        <?php
        $form->fieldConfig['template'] =  '{label}<div class="col-sm-11">{input}{hint}{error}</div>';
        $form->fieldConfig['labelOptions']['class'] =  'control-label col-sm-1';
        ?>
        <?= $form->field($addition, 'address')->textArea(['rows' => 6]) ?>
        <?= $form->field($addition, 'hobby')->textArea(['rows' => 6]) ?>
        <?= $form->field($addition, 'native_place')->textArea(['rows' => 6]) ?>
        <?= $form->field($addition, 'intro')->textArea(['rows' => 6]) ?>
    </div>

    <div class="col-md-12">
        <?php foreach ($attach as $k => $v): ?>
            <?php if ($v['html'] == 'input'): ?>
                <?= $form->field($addition, $v['name'])->textInput(['value'=>isset($addition)?$addition->$v['name']:'']) ?>
            <?php elseif($v['html'] == 'textarea'): ?>
                <?= $form->field($addition, $v['name'])->textarea(['rows' => 6, 'value'=>isset($addition)?$addition->$v['name']:'']) ?>
            <?php elseif($v['html'] == 'fulltext'): ?>
                <?= $form->field($addition,$v['name'])->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'post', 'use'=>'ue'], 'value'=>isset($addition)?$addition->$v['name']:''])->label($v['title']); ?>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>



