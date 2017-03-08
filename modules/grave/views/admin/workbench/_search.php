<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;
use app\assets\ExtAsset;

ExtAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\PortraitSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="portrait-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'grave_id')->dropDownList( Grave::selTree(['is_leaf'=>1], 0, ''), ['class'=>'sel-ize selg', 'style'=>'width:100px;'])->label(false) ?>

    <?= $form->field($model, 'row')->textInput(['class'=>'form-control srow', 'placeholder'=>'排'])->label(false) ?>

    <?= $form->field($model, 'col')->textInput(['class'=>'form-control scol', 'placeholder'=>'号'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
