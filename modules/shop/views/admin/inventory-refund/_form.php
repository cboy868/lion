<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\InventoryPurchaseRefund */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-purchase-refund-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'purchase_rel_id')->textInput() ?>

    <?= $form->field($model, 'num')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_id')->textInput() ?>

    <?= $form->field($model, 'op_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ct_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ct_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
