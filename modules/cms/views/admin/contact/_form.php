<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

     <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'captchaAction' => '/admin/cms/contact/captcha',
                    'template' => '<div class="row"><div class="col-lg-3">{input}</div><div class="col-lg-3">{image}</div></div>',
                ]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
