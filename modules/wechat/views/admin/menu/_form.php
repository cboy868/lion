<?php

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\wechat\models\Wechat;
use app\modules\wechat\models\Menu;

/* @var $this yii\web\View */
/* @var $model modules\wechat\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->dropDownList(Menu::menusMap()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->radioList(Menu::typeMap(), ['value'=>1]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>



	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
