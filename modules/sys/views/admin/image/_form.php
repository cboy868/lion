<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sys\models\ImageConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'res_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_thumb')->textInput() ?>

    <?= $form->field($model, 'thumb_mode')->textInput() ?>

    <?= $form->field($model, 'thumb_config')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_water')->textInput() ?>

    <?= $form->field($model, 'water_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'water_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'water_opacity')->textInput() ?>

    <?= $form->field($model, 'water_pos')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
