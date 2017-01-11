<?php 

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = '登录后台管理';
$this->params['breadcrumbs'][] = $this->title;
?>


<style type="text/css">
    body{background: url(/static/libs/member/images/bg.jpg);}
</style>
<div class="container">
    <div class="line bouncein" style="padding-top:100px;">
        <div class="xs6 xm4 xs3-move xm4-move">
            <div class="site-login">

                <?php $form = ActiveForm::memberBegin([
                    'fieldConfig' => [
                        'inputOptions' => ['class' => 'input-big input']
                    ],

                ]); ?>

                <div class="panel loginbox">
                    <div class="text-center margin-big padding-big-top"><h1>后台管理中心</h1></div>
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
