<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\DeadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dead-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'tomb_id') ?>

    <?= $form->field($model, 'memorial_id') ?>

    <?= $form->field($model, 'dead_name') ?>

    <?php // echo $form->field($model, 'second_name') ?>

    <?php // echo $form->field($model, 'dead_title') ?>

    <?php // echo $form->field($model, 'serial') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'birth_place') ?>

    <?php // echo $form->field($model, 'birth') ?>

    <?php // echo $form->field($model, 'fete') ?>

    <?php // echo $form->field($model, 'is_alive') ?>

    <?php // echo $form->field($model, 'is_adult') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'follow_id') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'is_ins') ?>

    <?php // echo $form->field($model, 'bone_type') ?>

    <?php // echo $form->field($model, 'bone_container') ?>

    <?php // echo $form->field($model, 'pre_bury') ?>

    <?php // echo $form->field($model, 'bury') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
