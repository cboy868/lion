<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\grave\models\Grave;

?>

<div class="tomb-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="col-md-6">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'cost')->textInput(['maxlength' => true])->label('穴数') ?>
        <?= $form->field($model, 'hole')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'thumb')->fileInput() ?>
        <?= $form->field($model, 'area_total')->textInput() ?>
        <?= $form->field($model, 'area_use')->textInput() ?>
    </div>



    <div class="col-md-12">
        <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    </div>



    <?=  Html::submitButton(' 保存 ', ['class' => 'btn btn-primary btn-lg', 'style'=>'float:right;']) ?>
    <?php ActiveForm::end(); ?>
</div>
