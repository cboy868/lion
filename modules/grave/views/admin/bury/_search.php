<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\BurySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bury-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tomb_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'dead_id') ?>

    <?= $form->field($model, 'dead_name') ?>

    <?php // echo $form->field($model, 'dead_num') ?>

    <?php // echo $form->field($model, 'bury_type') ?>

    <?php // echo $form->field($model, 'pre_bury_date') ?>

    <?php // echo $form->field($model, 'bury_date') ?>

    <?php // echo $form->field($model, 'bury_time') ?>

    <?php // echo $form->field($model, 'bury_user') ?>

    <?php // echo $form->field($model, 'bury_order') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
