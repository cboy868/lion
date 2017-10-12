<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['current_menu'] = 'memorial/default/index';
?>

<div class="memorial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->fileInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'privacy')->dropDownList(\app\modules\memorial\models\Memorial::privacys()) ?>

    <?= $form->field($model, 'tpl')->textInput() ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
