<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mess\models\SearchMessDayMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mess-day-menu-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'day_time') ?>

    <?= $form->field($model, 'menu_id') ?>

    <?= $form->field($model, 'real_price') ?>

    <?= $form->field($model, 'check_price') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'is_special') ?>

    <?php // echo $form->field($model, 'mess_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
