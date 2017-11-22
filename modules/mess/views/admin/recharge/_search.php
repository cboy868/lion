<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

\app\assets\ExtAsset::register($this);
?>

<div class="mess-user-recharge-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <div style="display: inline-block">
        <?= $form->field($model, 'start')->textInput(['dt'=>'true','dt-month'=>'true'])
            ->label('充值时间: ') ?> -
        <?= $form->field($model, 'end')->textInput(['dt'=>'true','dt-month'=>'true'])
            ->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
