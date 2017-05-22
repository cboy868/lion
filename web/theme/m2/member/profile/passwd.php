<?php
use app\core\helpers\Url;
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
?>
<style>
    input, select,textarea{
        font-size: 25px;
        padding: 5px;
    }
    label{
        font-size: 20px;
    }
    .field{
        margin-bottom:10px;
    }
    .has-error .help-block{
        color:red;
    }
</style>
<div id="main-content">
    <div class="setting">
        <h2>个人设置</h2>
        <?php echo \app\core\widgets\Alert::widget(); ?>
        <!-- 个人设置导航 start -->
        <div class="tab-header">
            <ul class="tabs clearfix">
                <li>
                    <a href="<?=Url::toRoute(['/user/member/profile/index'])?>">个人设置</a>
                </li>
                <li>
                    <a href="<?=Url::toRoute(['/user/member/profile/avatar'])?>">修改头像</a>
                </li>
                <li class="curr">
                    <a href="<?=Url::toRoute(['/user/member/profile/passwd'])?>">修改密码</a>
                </li>
            </ul>
        </div>

        <div class="setting-info">

            <?php $form = ActiveForm::memberBegin(); ?>
            <div class="xb6 xl8">
                <?= $form->field($pwd, 'oldpassword')->passwordInput(['maxlength' => true])->label('原始密码'); ?>
                <?= $form->field($pwd, 'password')->passwordInput(['maxlength' => true])->label('新密码') ?>
                <?= $form->field($pwd, 'repassword')->passwordInput(['maxlength' => true])->label('密码确认') ?>
            </div>
            <div class="xb12 xl12">
                <div class="form-group">
                    <div class="x4">
                        <?=  Html::submitButton('保 存', ['class' => '','style'=>'padding: 10px 20px;']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>