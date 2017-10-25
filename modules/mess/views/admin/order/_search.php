<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mess\models\SearchMessUserOrderMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mess-user-order-menu-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mess_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'day_menu_id') ?>

    <?= $form->field($model, 'menu_id') ?>

    <?php // echo $form->field($model, 'day_time') ?>

    <?php // echo $form->field($model, 'real_price') ?>

    <?php // echo $form->field($model, 'num') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'is_pre') ?>

    <?php // echo $form->field($model, 'is_over') ?>

    <?php // echo $form->field($model, 'is_mobile') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
