<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = '修改密码';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-login" style="margin: auto; width: 80%;">

<?php $form = ActiveForm::begin(); ?>

<div class="panel loginbox">
        <div class="row">
        <div class="col-md-5">
            <div class=" margin-big padding-big-top"><h1>修改密码</h1></div>

            <?= $form->field($pwd, 'password')->passwordInput() ?>
        <?= $form->field($pwd, 'repassword')->passwordInput() ?>

        <div class="form-group">
                <?= Html::submitButton('确 定', ['class' => 'btn btn-success']) ?>
        </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>
