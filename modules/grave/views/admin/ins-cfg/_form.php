<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\InsCfg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ins-cfg-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('英文字母、下划线、数字，字母开头') ?>

    <?= $form->field($model, 'shape')->dropDownList(['h'=> '横', 'v'=>'竖']) ?>

    <?= $form->field($model, 'is_god')->radioList(['普通', '天主']) ?>

    <?= $form->field($model, 'is_front')->radioList(['背面', '正面']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
