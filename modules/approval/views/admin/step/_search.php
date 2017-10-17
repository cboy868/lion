<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\SearchApprovalStep */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-step-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'approval_id') ?>

    <?= $form->field($model, 'step_name') ?>

    <?= $form->field($model, 'step') ?>

    <?= $form->field($model, 'approval_user') ?>

    <?php // echo $form->field($model, 'progress') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
