<?php

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\Type;
use app\modules\shop\models\Attr;

/* @var $this yii\web\View */
/* @var $model modules\foods\models\AttrVal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="foods-attr-val-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->category_id): ?>
        <?= $form->field($model, 'type_id')->hiddenInput(['value'=>$model->type_id])->label(false) ?>
    <?php else: ?>
        <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(Type::find()->all(), 'id', 'title')) ?>
    <?php endif ?>

    <?php if ($model->attr_id): ?>
        <?= $form->field($model, 'attr_id')->hiddenInput(['value'=>$model->attr_id])->label(false) ?>
    <?php else: ?>
        <?= $form->field($model, 'attr_id')->dropDownList(Attr::getMap()) ?>
    <?php endif ?>
    
    <?= $form->field($model, 'val')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
