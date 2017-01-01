<?php

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\MixCate

/* @var $this yii\web\View */
/* @var $model modules\foods\models\Mix */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mix-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mix_cate')->dropDownList(MixCate::selTree()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
