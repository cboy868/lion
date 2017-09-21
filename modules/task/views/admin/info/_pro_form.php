<?php

use app\core\helpers\Html;

use yii\widgets\ActiveForm;
use app\modules\task\models\Info;

?>

<div class="info-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'trigger')->radioList(Info::trig())?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6])?>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
