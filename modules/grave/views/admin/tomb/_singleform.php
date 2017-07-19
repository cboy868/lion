<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;

?>

<div class="tomb-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $form->fieldConfig = [
        'template' => '{label}<div class="col-sm-8">{input}{hint}{error}</div>',
        'labelOptions' => [
            'class' => 'control-label col-sm-4'
        ]
    ];?>

    <div class="col-md-6">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'hole')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'thumb')->fileInput() ?>
        <?= $form->field($model, 'area_total')->textInput() ?>
        <?= $form->field($model, 'area_use')->textInput() ?>
    </div>

    <?php $form->fieldConfig = [
        'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>',
        'labelOptions' => [
            'class' => 'control-label col-sm-2'
        ]
    ];?>

    <div class="col-md-12">
        <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    </div>




    <?=  Html::submitButton(' 保存 ', ['class' => 'btn btn-primary btn-lg', 'style'=>'float:right;']) ?>
    <?php ActiveForm::end(); ?>
</div>
