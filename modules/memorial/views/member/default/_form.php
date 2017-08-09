<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="memorial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->fileInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'privacy')->dropDownList(\app\modules\memorial\models\Memorial::privacys()) ?>

    <div class="xb12 xl12">
        <div class="form-group">
            <div class="x1-move x4">
                <?=  Html::submitButton(' 保 存 ', ['class' => 'button bg-sub btn btn-success btn-lg','style'=>'width:100px;']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
