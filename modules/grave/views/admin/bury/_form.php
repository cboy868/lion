<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Bury */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bury-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tomb_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'dead_id')->textInput() ?>

    <?= $form->field($model, 'dead_name')->textInput() ?>

    <?= $form->field($model, 'dead_num')->textInput() ?>

    <?= $form->field($model, 'bury_type')->textInput() ?>

    <?= $form->field($model, 'pre_bury_date')->textInput() ?>

    <?= $form->field($model, 'bury_date')->textInput() ?>

    <?= $form->field($model, 'bury_time')->textInput() ?>

    <?= $form->field($model, 'bury_user')->textInput() ?>

    <?= $form->field($model, 'bury_order')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
