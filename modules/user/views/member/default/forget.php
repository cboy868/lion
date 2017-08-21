<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
$this->title = '找回密码';
?>


<div class="site-login" style="margin: auto; width: 80%;">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写您注册时使用的邮箱:</p>
    <div class="row">
    <div class="col-md-5">
        <?= \app\core\widgets\Alert::widget()?>
        <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'verifyCode')->textInput() ?>
                <?php echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'/member/default/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;'],'template'=>'{image}']); ?>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('提 交', ['class' => 'btn btn-success btn-lg']) ?>
                    </div>
                </div>
        <?php ActiveForm::end(); ?>
    </div>
    </div>
</div>
