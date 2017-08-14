<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\TrackSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="track-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'res_id') ?>

    <?= $form->field($model, 'res_name') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'y') ?>

    <?php // echo $form->field($model, 'm') ?>

    <?php // echo $form->field($model, 'd') ?>

    <?php // echo $form->field($model, 'h') ?>

    <?php // echo $form->field($model, 'w') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
