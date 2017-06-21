<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\Type;
use app\core\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Attr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attr-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(Type::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'type_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('名字') ?>

    <?= $form->field($model, 'is_multi')->dropDownList(\app\modules\shop\models\Attr::multi())->label('输入类型') ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
