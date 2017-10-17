<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\ApprovalGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'approval_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num')->textInput() ?>

    <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
