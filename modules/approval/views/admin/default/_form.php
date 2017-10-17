<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\Approval */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->textInput() ?>

    <?= $form->field($model, 'process_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yet_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'progress')->textInput() ?>

    <?= $form->field($model, 'nowstep')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'eng_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
