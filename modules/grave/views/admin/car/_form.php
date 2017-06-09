<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Car;
/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Car */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(Car::types(), ['prompt'=>'车辆类型']); ?>

    <?php // $form->field($model, 'keeper')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
