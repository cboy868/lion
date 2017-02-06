<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Ins */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ins-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'guide_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'tomb_id')->textInput() ?>

    <?= $form->field($model, 'op_id')->textInput() ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shape')->textInput() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_tc')->textInput() ?>

    <?= $form->field($model, 'font')->textInput() ?>

    <?= $form->field($model, 'font_num')->textInput() ?>

    <?= $form->field($model, 'new_font_num')->textInput() ?>

    <?= $form->field($model, 'is_confirm')->textInput() ?>

    <?= $form->field($model, 'confirm_date')->textInput() ?>

    <?= $form->field($model, 'confirm_by')->textInput() ?>

    <?= $form->field($model, 'pre_finish')->textInput() ?>

    <?= $form->field($model, 'finish_at')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'paint')->textInput() ?>

    <?= $form->field($model, 'is_stand')->textInput() ?>

    <?= $form->field($model, 'paint_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'letter_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tc_price')->textInput(['maxlength' => true]) ?>

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
