<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
?>



<?php $form = ActiveForm::memberBegin(); ?>

    <div class="xb6 xl12">
        <?= $form->field($addition, 'real_name')->textInput(['maxlength' => true])->label('Your name') ?>
        <?= $form->field($addition, 'gender')->radioList(['1'=> 'male', '2'=>'female'])->label('Sex') ?>
        
        <?php //echo $form->field($addition, 'height')->textInput(['maxlength' => true, 'placeholder'=>'单位:cm']) ?>
        <?php //echo $form->field($addition, 'birth')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="xb6 xl12">
        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label('Mobile') ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email') ?>
        <?php //echo $form->field($addition, 'weight')->textInput(['maxlength' => true, 'placeholder'=>'单位:kg']) ?>
        <?php //echo $form->field($addition, 'qq')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="xb6 xl12">
        <?php //echo $form->field($addition, 'native_place')->textArea(['rows' => 6]) ?>
        <?= $form->field($addition, 'intro')->textArea(['rows' => 6])->label('Personal introduction') ?>
    </div>

    <div class="xb6 xl12">
        <?php //echo $form->field($addition, 'address')->textArea(['rows' => 6]) ?>
        <?= $form->field($addition, 'hobby')->textArea(['rows' => 6])->label('Hobby') ?>
    </div>

    
    <?php foreach ($attach as $k => $v): ?>
        <div class="xb6 xl12">
        <?php if ($v['html'] == 'input'): ?>
            <?= $form->field($addition, $v['name'])->textInput(['value'=>isset($addition)?$addition->$v['name']:'']) ?>
        <?php elseif($v['html'] == 'textarea'): ?>
            <?= $form->field($addition, $v['name'])->textarea(['rows' => 6, 'value'=>isset($addition)?$addition->$v['name']:'']) ?>
        <?php elseif($v['html'] == 'fulltext'): ?>
            <?= $form->field($addition,$v['name'])->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'post', 'use'=>'ue'], 'value'=>isset($addition)?$addition->$v['name']:''])->label($v['title']); ?>
        <?php endif ?>
        </div>
    <?php endforeach ?>
    

    <div class="xb12 xl12">
        <div class="form-group">
            <div class="x4">
                <?=  Html::submitButton('保 存', ['class' => 'button button-block bg-sub']) ?>
            </div>
        </div>
    </div>


<?php ActiveForm::end(); ?>







