<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\order\models\Order;
\app\assets\ExtAsset::register($this);
?>

<div class="order-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id')->textInput(['style'=>'width:80px'])->label('订单ID') ?>

    <?= $form->field($model, 'uname')->label('购买人') ?>

    <?php echo $form->field($model, 'progress')->dropDownList(Order::pro(), ['prompt'=>'不限'])->label('订单进度') ?>

    <div style="display: inline-block">
        <?= $form->field($model, 'start')->textInput(['dt'=>'true','dt-month'=>'true'])->label('下单时间: ') ?> -
        <?= $form->field($model, 'end')->textInput(['dt'=>'true','dt-month'=>'true'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm',
            'name'=>"excel", 'value'=>0]) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
        <?= Html::submitButton('<i class="fa fa-file-excel-o"></i>  导出excel',['class'=>'btn btn-danger btn-sm',
            'name'=>'excel', 'value'=>1]);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
