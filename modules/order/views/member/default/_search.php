<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\order\models\Order;
/* @var $this yii\web\View */
/* @var $model app\modules\order\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?php echo $form->field($model, 'progress')->dropDownList(Order::pro(), ['prompt'=>'不 限'])
        ->label('订单进度') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm',
            'name'=>"excel", 'value'=>0]) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
        <?= Html::submitButton('<i class="fa fa-file-excel-o"></i>  导出excel',['class'=>'btn btn-danger btn-sm',
            'name'=>'excel', 'value'=>1]);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
