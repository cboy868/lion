<?php
use app\core\helpers\Url;
use app\core\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '修改密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    input, select,textarea{
        font-size: 25px;
        padding: 5px;
    }
    label{
        /*font-size: 20px;*/
    }
    .field{
        margin-bottom:10px;
    }
    .has-error .help-block{
        color:red;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
    <?=\app\core\widgets\Alert::widget()?>
        <div class="row">
            <div class="col-xs-12 user-index">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li>
                        <a href="<?=Url::toRoute(['/user/member/profile/index'])?>">个人信息</a>
                    </li>
                    <li>
                        <a href="<?=Url::toRoute(['/user/member/profile/avatar'])?>">修改头像</a>
                    </li>
                    <li class="active">
                        <a href="<?=Url::toRoute(['/user/member/profile/passwd'])?>">修改密码</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="profile">
                        <div class="row">
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="col-md-12">
                                <?= $form->field($pwd, 'oldpassword')
                                    ->passwordInput(['maxlength' => true])
                                    ->label('原始密码'); ?>
                                <?= $form->field($pwd, 'password')
                                    ->passwordInput(['maxlength' => true])
                                    ->label('新密码') ?>
                                <?= $form->field($pwd, 'repassword')
                                    ->passwordInput(['maxlength' => true])
                                    ->label('密码确认') ?>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                        <?=  Html::submitButton('保 存', ['class' => '','style'=>'padding: 10px 20px;']) ?>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="hr hr-18 dotted hr-double"></div>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
