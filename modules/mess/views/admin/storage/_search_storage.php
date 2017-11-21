<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\mess\models\MessSupplier;
use app\modules\mess\models\Mess;
use app\modules\mess\models\MessFood;
?>

<div class="mess-storage-record-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'mess_id')->dropDownList(Mess::sel(),['prompt'=>'--不限--']) ?>

    <?= $form->field($model, 'food_id')->dropDownList(MessFood::sel(),['prompt'=>'--不限--']) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
