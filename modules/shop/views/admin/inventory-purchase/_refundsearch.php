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
    <?php $form->action= Url::toRoute(['refunds'])?>

    <?= $form->field($model, 'gname') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
