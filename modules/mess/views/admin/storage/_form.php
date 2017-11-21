<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\mess\models\MessSupplier;
use app\modules\mess\models\Mess;
use app\modules\mess\models\MessFood;
use app\modules\mess\models\MessStorageRecord;

\app\assets\ExtAsset::register($this);
?>

<div class="mess-storage-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'supplier_id')->dropDownList(MessSupplier::sel()) ?>

    <?= $form->field($model, 'mess_id')->dropDownList(Mess::sel()) ?>

    <?= $form->field($model, 'food_id')->dropDownList(MessFood::sel()) ?>

    <?= $form->field($model, 'dt')->textInput(['dt'=>'true']) ?>

    <?= $form->field($model, 'number')->textInput(['class'=>'form-control num']) ?>

    <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true, 'class'=>'form-control up']) ?>

    <?= $form->field($model, 'count_price')->textInput(['maxlength' => true, 'class'=>'form-control cp']) ?>

    <?= $form->field($model, 'type')->hiddenInput(['value' => MessStorageRecord::TYPE_IN])->label(false) ?>


	<div class="form-group">
        <div class="col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('cate') ?>
$(function(){
    LN.dtInit();

    $('.num,.up').change(function(){
        var num = $('.num').val();
        var up = $('.up').val();

        var total = parseFloat(num) * parseFloat(up);

        if (isNaN(total)){
            total = 0;
        }
        $('.cp').val(total);
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>

