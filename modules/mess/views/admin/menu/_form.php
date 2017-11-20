<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\mess\models\MessMenuCategory;
?>

<div class="mess-menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(MessMenuCategory::sel(),['prompt'=>'请选择分类']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'default_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['maxlength' => true,'rows'=>6]) ?>

    <?= $form->field($model, 'cover')->fileInput(['maxlength' => true]) ?>

	<div class="form-group row">
        <div class="col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
