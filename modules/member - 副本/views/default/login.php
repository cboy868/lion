<?php 

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;
$this->title = '登录会员中心';
?>


<style type="text/css">
    body{background: url(/static/libs/member/images/bg.jpg);}
</style>
<div class="container">





    <div class="line bouncein" style="">
        <div class="xs6 xm4 xs3-move xm4-move">

            <?php if (Yii::$app->getSession()->hasFlash('success')): ?>
                 <p class="bg-main" style="padding:15px 20px">
                    提示: <?=Yii::$app->getSession()->getFlash('success')?>
                </p>
            <?php endif ?>
            <?php if (Yii::$app->getSession()->hasFlash('error')): ?>
                 <p class="bg-dot" style="padding:15px 20px">
                    提示: <?=Yii::$app->getSession()->getFlash('error')?>
                </p>
            <?php endif ?>

            <div class="site-login">

                <?php $form = ActiveForm::memberBegin([
                    'fieldConfig' => [
                        'inputOptions' => ['class' => 'input-big input']
                    ],

                ]); ?>

                <div class="panel loginbox">
                    <div class="text-center margin-big padding-big-top"><h1>会员中心</h1></div>
                    <div class="panel-body" style="padding:30px; padding-bottom:10px; padding-top:10px;">

                        <?php $form->fieldConfig['template'] = "{label}<div class=\"field field-icon-right\">{input}<span class=\"icon icon-user margin-small\"></span>{error}</div>"; ?>
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>


                        <?php $form->fieldConfig['template'] = "{label}<div class=\"field field-icon-right\">{input}<span class=\"icon icon-key margin-small\"></span>{error}</div>"; ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?php $form->fieldConfig['template'] = "{label}<div class=\"field\">{input}{hint}{error}</div>"; ?>


                        <?= $form->field($model, 'verifyCode')->textInput() ?>
                        <?php echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'default/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;'],'template'=>'{image}']); ?>
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ]) ?>
                        
                        <div class="form-group">
                            <a href="<?=Url::toRoute(['/member/user/default/forget'])?>" style="float:right;font-size:18px;color:#999"> 忘记密码?</a>
                            <a href="<?=Url::toRoute(['/member/default/reg'])?>" style="float:right;font-size:18px;color:#999">还没有账号 | </a>
                        </div>
                        <div class="form-group">

                            <div class="col-lg-offset-1 col-lg-11">
                                <?= Html::submitButton('登录', ['class' => 'button button-block bg-main text-big input-big', 'name' => 'login-button']) ?>

                            </div>

                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
