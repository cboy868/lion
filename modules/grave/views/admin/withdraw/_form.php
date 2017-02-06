<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Withdraw */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'guide_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'tomb_id')->textInput() ?>

    <?= $form->field($model, 'current_tomb_id')->textInput() ?>

    <?= $form->field($model, 'refund_id')->textInput() ?>

    <?= $form->field($model, 'ct_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ct_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ct_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ct_relation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reson')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_tomb_id')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
