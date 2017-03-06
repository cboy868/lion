<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

\app\assets\ExtAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\sms\models\Send */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="send-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->radioList(['全体员工', '所有客户', '自定义']) ?>

    <?= $form->field($model, 'msg')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mobile')->textArea(['rows' => 6])->hint('多个电话请用逗号(,)分隔') ?>

    <?= $form->field($model, 'time')->textInput(['dt'=>'true', 'style'=>'width:50%'])->hint('不填写则马上发送') ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
