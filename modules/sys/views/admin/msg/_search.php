<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sys\models\MsgSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msg-search">

    <?php $form = ActiveForm::searchBegin(); ?>


    <?= $form->field($model, 'msg') ?>

    <?= $form->field($model, 'msg_type')->dropDownList(\app\modules\sys\models\Msg::types()) ?>

    <?php // echo $form->field($model, 'res_name') ?>

    <?php // echo $form->field($model, 'res_id') ?>

    <?php // echo $form->field($model, 'tid') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>