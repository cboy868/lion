<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\mess\models\Mess;
use yii\helpers\ArrayHelper;

$mess = Mess::find()->where(['status'=>Mess::STATUS_NORMAL])->all();
$mess = ArrayHelper::map($mess, 'id', 'name');
?>

<div class="mess-supplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mess_id')->dropDownList($mess, ['prompt'=>'请选择食堂']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea() ?>

	<div class="form-group">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
