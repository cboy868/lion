<?php

use yii\helpers\Html;
use core\widgets\ActiveForm;
use modules\wechat\models\Wechat;
/* @var $this yii\web\View */
/* @var $model modules\wechat\models\Wechat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('微信公众号名称') ?>

    <?= $form->field($model, 'appid')->textInput(['maxlength' => true])->hint('应用id,在微信公众平台基本配置中查看') ?>
    
    <?= $form->field($model, 'wechat_id')->textInput(['maxlength' => true])->hint('微信公众号原始id,在公众号注册信息栏,gh_开头的字符串') ?>

    <?= $form->field($model, 'secret')->textInput(['maxlength' => true])->hint('在微信公众平台基本配置中查看') ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true])->hint('添写与公众号中配置一至的token') ?>

    <?= $form->field($model, 'encodekey')->textInput(['maxlength' => true])->hint('添写与公众号中配置一至的消息加解密密钥'); ?>

    <?= $form->field($model, 'type')->radioList(Wechat::typeMap())->hint('请与公众号中配置一至') ?>

    <div class="form-group field-wechat-encodekey">
        <label class="control-label col-sm-2" for="wechat-encodekey">i值</label>
        <div class="col-sm-10">
        <?='http://' . $_SERVER['HTTP_HOST'] .'?r=wechat&i='.$model->i?>
        </div>
    </div>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
