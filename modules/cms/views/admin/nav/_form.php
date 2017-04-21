<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Nav */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nav-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
        $form->fieldConfig['template'] = '{label}<div class="col-sm-11">{input}{hint}{error}</div>';
        $form->fieldConfig['labelOptions']['class'] = 'control-label col-sm-1';
     ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>'width:50%']) ?>
    <?php 
        $mods = $this->context->module->params['nav_module'];
        $mods = ArrayHelper::map($mods, 'url', 'title');

     ?>

    <?= $form->field($model, 'url')->dropDownList($mods) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('请输入本页面标题,会影响到搜索引擎排名') ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true])->hint('请输入本页面关键词,会影响到搜索引擎排名') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->hint('请输入本页面描述,会影响到搜索引擎排名') ?>

    <?= $form->field($model, 'sort')->textInput(['style'=>'width:50%']) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
