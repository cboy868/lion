<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\order\models\Delay;

/* @var $this yii\web\View */
/* @var $model app\modules\order\models\DelaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delay-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'uname') ?>

    <?= $form->field($model, 'is_verified')->dropDownList(Delay::getVerfy()) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
