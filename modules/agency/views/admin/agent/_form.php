<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\agency\models\Agency;
$cates = Agency::find()->where(['status'=>Agency::STATUS_NORMAL])->all();
$cates = \yii\helpers\ArrayHelper::map($cates, 'id', 'title');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])
        ->label('账号')->hint('填写后不可修改') ?>

    <?= $form->field($model, 'category')->dropDownList($cates, ['prompt'=>'请选择隶属办事处']) ?>

    <?= $form->field($model, 'is_staff')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->hint('默认密码:999999') ?>

    <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => true]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
