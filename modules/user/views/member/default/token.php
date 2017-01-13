<?php 

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = '修改密码';
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
                    <div class="text-center margin-big padding-big-top"><h1>修改密码</h1></div>
                    <div class="panel-body" style="padding:30px; padding-bottom:10px; padding-top:10px;">

                        <?php $form->fieldConfig['template'] = "{label}<div class=\"field field-icon-right\">{input}<span class=\"icon icon-key margin-small\"></span>{error}</div>"; ?>
                        <?= $form->field($pwd, 'password')->passwordInput() ?>
                        <?= $form->field($pwd, 'repassword')->passwordInput() ?>

                        <div class="form-group">
                            <div class="col-lg-offset-1 col-lg-11">
                                <?= Html::submitButton('确 定', ['class' => 'button button-block bg-main text-big input-big', 'name' => 'login-button']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
