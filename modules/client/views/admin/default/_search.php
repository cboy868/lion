<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
\app\assets\ExtAsset::register($this);
?>

<div class="client-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'telephone') ?>

    <?= $form->field($model, 'mobile') ?>

    <div style="display: inline-block">
    <?= $form->field($model, 'start')->textInput(['dt'=>'true','dt-month'=>'true'])->label('创建时间: ') ?> -
    <?= $form->field($model, 'end')->textInput(['dt'=>'true','dt-month'=>'true'])->label(false) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm','name'=>"excel", 'value'=>0]) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
        <?= Html::submitButton('<i class="fa fa-file-excel-o"></i>  导出excel',['class'=>'btn btn-danger btn-sm', 'name'=>'excel', 'value'=>1]);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
