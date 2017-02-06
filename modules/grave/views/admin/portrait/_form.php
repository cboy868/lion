<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Portrait */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portrait-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'guide_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'tomb_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_id')->textInput() ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'order_rel_id')->textInput() ?>

    <?= $form->field($model, 'dead_ids')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo_processed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'confrim_by')->textInput() ?>

    <?= $form->field($model, 'confirm_at')->textInput() ?>

    <?= $form->field($model, 'photo_confirm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'use_at')->textInput() ?>

    <?= $form->field($model, 'up_at')->textInput() ?>

    <?= $form->field($model, 'notice_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

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
