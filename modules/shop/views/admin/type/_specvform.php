<?php

use yii\helpers\Html;
use app\core\helpers\ArrayHelper;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\Type;
use app\modules\shop\models\Attr;
use app\core\helpers\Url;


/* @var $this yii\web\View */
/* @var $model modules\foods\models\AttrVal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="foods-attr-val-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
        $form->method = 'post';
    ?>

    <?= $form->field($model, 'type_id')->hiddenInput(['value'=>$model->type_id])->label(false) ?>

    <?= $form->field($model, 'attr_id')->hiddenInput(['value'=>$model->attr_id])->label(false) ?>
    
    <?= $form->field($model, 'val')->textInput(['maxlength' => true])->label('值') ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
