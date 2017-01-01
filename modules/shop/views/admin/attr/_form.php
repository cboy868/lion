<?php

use app\core\helpers\Html;
use app\core\helpers\ArrayHelper;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\Type;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Attr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attr-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(Type::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_multi')->dropDownList([0=>'否',1=>'是']) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
