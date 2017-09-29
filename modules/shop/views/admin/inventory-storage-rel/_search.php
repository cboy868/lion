<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\InventoryStorage;
?>

<div class="inventory-storage-rel-search">

    <?php $form = ActiveForm::searchBegin(); ?>
<?php

$storages = InventoryStorage::find()->where(['status'=>InventoryStorage::STATUS_NORMAL])->all();
$s = \yii\helpers\ArrayHelper::map($storages, 'id', 'name');
?>
    <?= $form->field($model, 'storage_id')->dropDownList($s, ['prompt'=>'不限']) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
