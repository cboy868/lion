<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\shop\models\InventorySupplier;
?>

<div class="inventory-supplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
//        $form->fieldConfig['template'] = '{label}<div class="col-sm-11">{input}{hint}{error}</div>';
//        $form->fieldConfig['labelOptions']['class'] = 'control-label col-sm-1';
     ?>

    <table class="table noborder">
        <tr>
            <td colspan="2">
                <?= $form->field($model, 'cp_name')->textInput(['maxlength' => true])->label('公司名<font color="red">(*)</font>') ?>
            </td>
            <td>
                <?= $form->field($model, 'cp_phone')->textInput(['maxlength' => true])->label('公司座机') ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?= $form->field($model, 'addr')->textarea(['rows' => 6])->label('公司地址<font color="red">(*)</font>') ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?= $form->field($model, 'ct_name')->textInput(['maxlength' => true])->label('联系人 <font color="red">(*)</font>') ?>
            </td>
            <td>
                <?= $form->field($model, 'ct_mobile')->textInput(['maxlength' => true])->label('联系人电话 <font color="red">(*)</font>') ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $form->field($model, 'ct_sex')->dropDownList(InventorySupplier::males()) ?>
            </td>
            <td>
                <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

            </td>
            <td>
                <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary']) ?>
                </div>
            </td>
        </tr>
    </table>

    <?php ActiveForm::end(); ?>

</div>
