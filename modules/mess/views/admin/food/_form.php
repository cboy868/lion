<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\mess\models\MessFoodCategory;

$units = Yii::$app->getModule('mess')->params['unit'];

?>

<div class="mess-food-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(MessFoodCategory::sel(),['prompt'=>'请选择分类']) ?>

    <?= $form->field($model, 'food_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_id')->dropDownList($units) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
