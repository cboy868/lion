<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;

/* @var $this yii\web\View */
/* @var $model sys\models\AuthGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-group-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'real_title') ?>
    
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
