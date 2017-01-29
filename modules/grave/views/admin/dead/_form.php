<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Dead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dead-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'tomb_id')->textInput() ?>

    <?= $form->field($model, 'memorial_id')->textInput() ?>

    <?= $form->field($model, 'dead_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'second_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dead_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serial')->textInput() ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'birth_place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth')->textInput() ?>

    <?= $form->field($model, 'fete')->textInput() ?>

    <?= $form->field($model, 'is_alive')->textInput() ?>

    <?= $form->field($model, 'is_adult')->textInput() ?>

    <?= $form->field($model, 'age')->textInput() ?>

    <?= $form->field($model, 'follow_id')->textInput() ?>

    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_ins')->textInput() ?>

    <?= $form->field($model, 'bone_type')->textInput() ?>

    <?= $form->field($model, 'bone_container')->textInput() ?>

    <?= $form->field($model, 'pre_bury')->textInput() ?>

    <?= $form->field($model, 'bury')->textInput() ?>

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
