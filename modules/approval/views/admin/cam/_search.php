<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\SearchApprovalCam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-cam-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'approval_id') ?>

    <?= $form->field($model, 'pay_type') ?>

    <?= $form->field($model, 'cam_no') ?>

    <?= $form->field($model, 'op_id') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'paid') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'cam_user') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
