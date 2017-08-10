<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\BlogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-search">

    <?php $form = ActiveForm::searchBegin(); ?>


    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'recommend') ?>

    <?php // echo $form->field($model, 'is_customer') ?>

    <?php // echo $form->field($model, 'is_top') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'memorial_id') ?>

    <?php // echo $form->field($model, 'privacy') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
