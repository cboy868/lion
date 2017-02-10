<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\InsCfgCase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ins-cfg-case-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'num')->textInput()->hint('如不添加此值，则会批量生成1-4个人的配置项') ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'cfg_id')->hiddenInput()->label(false) ?>
	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
