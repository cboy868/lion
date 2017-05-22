<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\wechat\models\Wechat;
/* @var $this yii\web\View */
/* @var $model app\modules\wechat\models\Wechat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->dropDownList(Wechat::levels()) ?>

    <?= $form->field($model, 'original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appid')->textInput(['maxlength' => true])
                ->hint('在微信公众平台获取');
    ?>

    <?= $form->field($model, 'appsecret')->textInput(['maxlength' => true])
        ->hint('在微信公众平台获取');
    ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
