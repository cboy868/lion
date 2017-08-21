<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;
$this->title = '会员注册';
?>




<div class="site-login" style="margin: auto; width: 80%;">


    <div class="row">
        <div class="col-md-5">
    <?php $form = ActiveForm::begin(); ?>

        <div class="text-center margin-big padding-big-top"><h1>会员注册</h1></div>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>


            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'repassword')->passwordInput() ?>


            <?= $form->field($model, 'verifyCode')->textInput() ?>
            <?php echo Captcha::widget([
                    'name'=>'captchaimg',
                'captchaAction'=>'default/captcha',
                'imageOptions'=>['id'=>'captchaimg',
                    'title'=>'换一个',
                    'alt'=>'换一个',
                    'style'=>'cursor:pointer;'
                ],'template'=>'{image}']); ?>

            <div class="form-group" style="text-align: right">
                    <?= Html::submitButton('注 册', ['class' => 'btn btn-success btn-lg']) ?>

                    <a class="btn btn-default btn-lg" href="<?=Url::toRoute(['/member/default/login'])?>" style="float:left;font-size:18px;color:#999">已有账号</a>
            </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
