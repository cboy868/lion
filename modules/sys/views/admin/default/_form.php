<?php

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\sys\models\Set;

/* @var $this yii\web\View */
/* @var $model app\models\Set */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="set-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sname')->textInput(['maxlength' => 20])->hint('请填写英文字母、下划线，字母开头,用做网站调用的关键司') ?>

    <?= $form->field($model, 'smodule')->dropDownList(Set::getModule()) ?>

    <?= $form->field($model, 'stype')->dropDownList(Set::getTypes()) ?>

    <?php //echo $form->field($model, 'svalues')->textarea(['rows' => 6])->hint('本值只有在输入类型为select,radio,checkbox时需要输入') ?>

    <?= $form->field($model, 'sintro')->textInput(['maxlength' => 255])->label('配置名') ?>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
