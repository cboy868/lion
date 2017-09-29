<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\shop\models\InventoryStorage;
use yii\helpers\ArrayHelper;
?>

<div class="inventory-storage-rel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $storages = InventoryStorage::find()->where(['status'=>InventoryStorage::STATUS_NORMAL])->all();
    $s = ArrayHelper::map($storages, 'id', 'name');
    ?>

    <?= $form->field($model, 'storage_id')->dropDownList($s, ['prompt'=>'请选择仓库']) ?>

    <?= $form->field($model, 'goods_id')->textInput() ?>

    <?= $form->field($model, 'sku_id')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
