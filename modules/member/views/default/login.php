<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;
$this->title = '登录会员中心';
?>

<div class="site-login" style="/*margin-left:190px;*/margin: auto; width: 80%;">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写用户名和密码:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'verifyCode')->textInput() ?>
            <?php echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'default/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;'],'template'=>'{image}']); ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('登 录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <a href="<?=Url::toRoute(['/member/user/default/forget'])?>" style="float:right;font-size:18px;color:#999"> 忘记密码?</a>
                <a href="<?=Url::toRoute(['/member/default/reg'])?>" style="float:right;font-size:18px;color:#999">还没有账号 | </a>
            </div>

            <div class="form-group">

            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

