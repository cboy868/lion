<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\assets\ExtAsset;
ExtAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Portrait */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portrait-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'use_at')->textInput(['dt'=>'true']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
