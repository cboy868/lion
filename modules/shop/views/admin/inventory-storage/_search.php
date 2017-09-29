<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use \app\modules\shop\models\InventoryStorage;
/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\search\InventoryStorage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-storage-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?php
    $form->action = Url::current(['id'=>Yii::$app->request->get('id')]);
    $storage = InventoryStorage::find()->where(['status'=>InventoryStorage::STATUS_NORMAL])->all();
    ?>
    <?= $form->field($model, 'name')->dropDownList(\yii\helpers\ArrayHelper::map($storage, 'id', 'name'),
        ['prompt'=>'不 限']) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
