<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mod\models\Module */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'module')->dropDownList($mods) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'dir')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'show')->radioList([0=>'否', 1=> '是']) ?>

    <?php //= $form->field($model, 'logo')->fileInput(['maxlength' => true]) ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
