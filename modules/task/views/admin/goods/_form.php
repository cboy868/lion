<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'info_id')->textInput() ?>

    <?= $form->field($model, 'res_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'res_id')->textInput() ?>

    <?= $form->field($model, 'msg_type')->textInput() ?>

    <?= $form->field($model, 'msg')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'msg_time')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'trigger')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
