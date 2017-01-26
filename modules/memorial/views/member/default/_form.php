<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\memorial\models\Memorial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="memorial-form">

    <?php $form = ActiveForm::memberBegin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cover')->fileInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'privacy')->textInput() ?>

    <?= $form->field($model, 'tpl')->textInput() ?>


    <div class="xb12 xl12">
        <div class="form-group">
            <div class="x1-move x4">
                <?=  Html::submitButton('保 存', ['class' => 'button bg-sub']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
