<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\search\InventoryPurchaseRel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-purchase-rel-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'record_id') ?>

    <?= $form->field($model, 'goods_id') ?>

    <?= $form->field($model, 'sku_id') ?>

    <?php // echo $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'num') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'retail') ?>

    <?php // echo $form->field($model, 'op_id') ?>

    <?php // echo $form->field($model, 'op_name') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
