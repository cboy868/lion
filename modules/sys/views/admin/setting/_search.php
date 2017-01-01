<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sys\models\SettingsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'sname') ?>

    <?= $form->field($model, 'svalue') ?>

    <?= $form->field($model, 'svalues') ?>

    <?= $form->field($model, 'sintro') ?>

    <?= $form->field($model, 'stype') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'smodule') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
