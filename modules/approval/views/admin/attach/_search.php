<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\SearchApprovalAttach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-attach-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'approve_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'ext') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
