<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\memorial\models\Rel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'res_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'res_id')->textInput() ?>

    <?= $form->field($model, 'res_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'res_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'res_cover')->textInput(['maxlength' => true]) ?>



	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
