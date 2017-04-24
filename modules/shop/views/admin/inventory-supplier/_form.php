<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\InventorySupplier;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\InventorySupplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-supplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $form->fieldConfig['template'] = '{label}<div class="col-sm-11">{input}{hint}{error}</div>';
        $form->fieldConfig['labelOptions']['class'] = 'control-label col-sm-1';
     ?>

    <?= $form->field($model, 'cp_name')->textInput(['maxlength' => true, 'style'=>'width:50%'])->label('公司名<font color="red">(*)</font>') ?>

    <?= $form->field($model, 'addr')->textarea(['rows' => 6, 'style'=>'width:50%'])->label('公司地址<font color="red">(*)</font>') ?>

    <?= $form->field($model, 'cp_phone')->textInput(['maxlength' => true, 'style'=>'width:30%'])->label('公司座机') ?>

    <?= $form->field($model, 'ct_name')->textInput(['maxlength' => true, 'style'=>'width:30%'])->label('联系人 <font color="red">(*)</font>') ?>

    <?= $form->field($model, 'ct_mobile')->textInput(['maxlength' => true, 'style'=>'width:30%'])->label('联系人电话 <font color="red">(*)</font>') ?>

    <?= $form->field($model, 'ct_sex')->dropDownList(InventorySupplier::males(),['style'=>'width:20%']) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true, 'style'=>'width:30%']) ?>

    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true, 'style'=>'width:30%']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-1 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
