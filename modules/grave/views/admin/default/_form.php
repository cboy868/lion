<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Grave */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grave-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $graves = Grave::selTree(); array_unshift($graves, ['0'=>'顶级']) ?>
    <?= $form->field($model, 'pid')->dropDownList($graves) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'area_totle')->textInput() ?>

    <?= $form->field($model, 'area_use')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
