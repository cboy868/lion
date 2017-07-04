<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ashes\models\LogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'action') ?>

    <?= $form->field($model, 'box_id') ?>

    <?= $form->field($model, 'area_id') ?>

    <?= $form->field($model, 'tomb_id') ?>

    <?php // echo $form->field($model, 'deads') ?>

    <?php // echo $form->field($model, 'bury_date') ?>

    <?php // echo $form->field($model, 'out_way') ?>

    <?php // echo $form->field($model, 'op_id') ?>

    <?php // echo $form->field($model, 'save_user') ?>

    <?php // echo $form->field($model, 'out_user') ?>

    <?php // echo $form->field($model, 'save_time') ?>

    <?php // echo $form->field($model, 'out_time') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'contact') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'relation') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
