<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ashes\models\Box */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'log_id')->textInput() ?>

    <?= $form->field($model, 'box_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_id')->textInput() ?>

    <?= $form->field($model, 'row')->textInput() ?>

    <?= $form->field($model, 'col')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
